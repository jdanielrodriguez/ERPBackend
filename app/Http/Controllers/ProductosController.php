<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Productos;
use App\Inventario;
use Response;
use Validator;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Productos::with('inventario')->get(), 200);
    }

    public function existencia()
    {
        return Response::json(Inventario::where('cantidad','>','0')->with('productos')->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'codigo'          => 'required',
            'nombre'          => 'required',
            'tipo'            => 'required'
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
            $objectSee = Productos::whereRaw('codigo=?',[$request->get('codigo')])->first();
            if ($objectSee) {
                $returnData = array (
                    'status' => 400,
                    'message' => 'Record found, already exist'
                );
                return Response::json($returnData, 400);
            }
            else {
                try {
                    $newObject = new Productos();
                    $newObject->descripcion       = $request->get('descripcion');
                    $newObject->nombre            = $request->get('nombre');
                    $newObject->codigo            = $request->get('codigo');
                    $newObject->marcaDes          = $request->get('marcaDes');
                    $newObject->tipo              = $request->get('tipo');
                    $newObject->save();
                    $newObject1 = new Inventario();
                    $newObject1->precioCosto       = $request->get('precioCosto',0);
                    $newObject1->precioVenta       = $request->get('precioVenta',0);
                    $newObject1->precioClienteEs   = $request->get('precioClienteEs',0);
                    $newObject1->precioDistribuidor= $request->get('precioDistribuidor',0);
                    $newObject1->cantidad          = $request->get('cantidad',0);
                    $newObject1->minimo            = $request->get('minimo',0);
                    $newObject1->descuento         = $request->get('descuento',0);
                    $newObject1->producto          = $newObject->id;
                    $newObject1->save();
                    $newObject->inventario;
                    return Response::json($newObject, 200);
                
                } catch (\Illuminate\Database\QueryException $e) {
                    if($e->errorInfo[0] == '01000'){
                        $errorMessage = "Error Constraint";
                    }  else {
                        $errorMessage = $e->getMessage();
                    }
                    $returnData = array (
                        'status' => 505,
                        'SQLState' => $e->errorInfo[0],
                        'message' => $errorMessage
                    );
                    return Response::json($returnData, 500);
                } catch (Exception $e) {
                    $returnData = array (
                        'status' => 500,
                        'message' => $e->getMessage()
                    );
                    return Response::json($returnData, 500);
                }
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
        $objectSee = Productos::find($id);
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
        $objectUpdate = Productos::find($id);
        if ($objectUpdate) {
            $objectSee = Productos::whereRaw('codigo=? and id!=?',[$request->get('codigo'),$id])->first();
            if (!$objectSee) {
                try {
                    $objectUpdate->descripcion       = $request->get('descripcion', $objectUpdate->descripcion);
                    $objectUpdate->nombre            = $request->get('nombre', $objectUpdate->nombre);
                    $objectUpdate->codigo            = $request->get('codigo', $objectUpdate->codigo);
                    $objectUpdate->marcaDes          = $request->get('marcaDes', $objectUpdate->marcaDes);
                    $objectUpdate->tipo              = $request->get('tipo', $objectUpdate->tipo);
                    $objectUpdate->estado            = $request->get('estado', $objectUpdate->estado);
                    $objectUpdate->marca             = $request->get('marca', $objectUpdate->marca);
                    
                    $objectUpdate->save();
                    return Response::json($objectUpdate, 200);
                } catch (\Illuminate\Database\QueryException $e) {
                    if($e->errorInfo[0] == '01000'){
                        $errorMessage = "Error Constraint";
                    }  else {
                        $errorMessage = $e->getMessage();
                    }
                    $returnData = array (
                        'status' => 505,
                        'SQLState' => $e->errorInfo[0],
                        'message' => $errorMessage
                    );
                    return Response::json($returnData, 500);
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
                    'status' => 400,
                    'message' => 'Record found, already exist'
                );
                return Response::json($returnData, 400);
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
        $objectDelete = Productos::find($id);
        if ($objectDelete) {
            try {
                Productos::destroy($id);
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