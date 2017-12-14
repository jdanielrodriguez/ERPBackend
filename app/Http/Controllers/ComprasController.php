<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Compras;
use App\ComprasDetalle;
use App\Inventario;
use Response;
use DB;
use Validator;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Compras::where('estado','=','1')->with('proveedores','tipos')->get(), 200);
    }

    public function anuladas()
    {
        return Response::json(Compras::where('estado','=','0')->with('proveedores','tipos')->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proveedor'      => 'required',
            'usuario'        => 'required',
            'total'          => 'required',
            'fecha'          => 'required',
            'tipo'           => 'required',
            'detalle'        => 'required'
        ]);
        if ( $validator->fails() ) {
            $returnData = array (
                'status' => 400,
                'message' => 'Invalid Parameters',
                'validator' => $validator
            );
            return Response::json($returnData, 400);
        }
        else {
            try {
                DB::beginTransaction();
                $newObject = new Compras();
                $newObject->proveedor            = $request->get('proveedor');
                $newObject->usuario              = $request->get('usuario');
                $newObject->total                = $request->get('total');
                $newObject->fecha                = $request->get('fecha');
                $newObject->tipo                 = $request->get('tipo');
                $newObject->save();
                if ( $request->get('detalle') )
                {
                   $Array = $request->get('detalle');
                   foreach ($Array as $value)
                    {
                        $registro = new ComprasDetalle();
                        $registro->subtotal    = $value['subtotal'];
                        $registro->cantidad    = $value['cantidad'];
                        $registro->costo       = $value['precioCosto'];
                        $registro->precio      = $value['precioVenta'];
                        $registro->precioE     = $value['precioClienteEs'];
                        $registro->precioM     = $value['precioDistribuidor'];
                        $registro->compra      = $newObject->id;
                        $registro->producto    = $value['producto'];
                        $registro->tipo        = $newObject->tipo;
                        $registro->save();
                        $objectUpdate = Inventario::find($value['id']);
                        if ($objectUpdate) {
                            try {
                                $objectUpdate->precioCosto        = $objectUpdate->precioCosto>0?(($objectUpdate->precioCosto+$value['precioCosto'])/2):$value['precioCosto'];
                                $objectUpdate->precioVenta        = $objectUpdate->precioVenta>0?(($objectUpdate->precioVenta+$value['precioVenta'])/2):$value['precioVenta'];
                                $objectUpdate->precioClienteEs    = $objectUpdate->precioClienteEs>0?(($objectUpdate->precioClienteEs+$value['precioClienteEs'])/2):$value['precioClienteEs'];
                                $objectUpdate->precioDistribuidor = $objectUpdate->precioDistribuidor>0?(($objectUpdate->precioDistribuidor+$value['precioDistribuidor'])/2):$value['precioDistribuidor'];
                                $objectUpdate->cantidad           = (($objectUpdate->cantidad+$value['cantidad']));
                                $objectUpdate->save();
                            } catch (Exception $e) {
                                $returnData = array (
                                    'status' => 500,
                                    'message' => $e->getMessage()
                                );
                                return Response::json($returnData, 500);
                            }
                        }
                        else {
                            $returnData = array (
                                'status' => 404,
                                'message' => 'No record found'
                            );
                            return Response::json($returnData, 404);
                        }
    
                    }
                    
                    DB::commit();
                    // $returnData = array (
                    //     'status' => 200,
                    //     'message' => "success"
                    // );
                    // return Response::json($returnData, 200);
                }
                else
                {
                    DB::rollback();
                    $returnData = array (
                        'status' => 400,
                        'message' => 'Invalid Parameters'
                    );
                    return Response::json($returnData, 400);
                }
                $newObject->detalle;
                
                return Response::json($newObject, 200);
            
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objectSee = Compras::with('detalle','proveedores','tipos')->find($id);
        if ($objectSee) {
            return Response::json($objectSee, 200);
        
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objectUpdate = Compras::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->estado = $request->get('estado', $objectUpdate->estado);
                $objectUpdate->save();
                $objectUpdate2 = ComprasDetalle::whereRaw('compra=?',$id)->get();
                if ($objectUpdate2) {
                    try {
                        foreach ($objectUpdate2 as $value) {
                            $actualiza = ComprasDetalle::find($value['id']);
                            if ($actualiza) {
                                try {
                                    $actualiza->estado = $request->get('estado', $actualiza->estado);
                                    $actualiza->save();
                                } catch (Exception $e) {
                                    $returnData = array (
                                        'status' => 500,
                                        'message' => $e->getMessage()
                                    );
                                    return Response::json($returnData, 500);
                                }
                            }
                            else {
                                $returnData = array (
                                    'status' => 404,
                                    'message' => 'No record found'
                                );
                                return Response::json($returnData, 404);
                            }
                        }
                        
                        return Response::json($objectUpdate, 200);
                    } catch (Exception $e) {
                        $returnData = array (
                            'status' => 500,
                            'message' => $e->getMessage()
                        );
                        return Response::json($returnData, 500);
                    }
                }
                else {
                    $returnData = array (
                        'status' => 404,
                        'message' => 'No record found'
                    );
                    return Response::json($returnData, 404);
                }
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objectDelete = Compras::find($id);
        if ($objectDelete) {
            try {
                Compras::destroy($id);
                return Response::json($objectDelete, 200);
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }
}
