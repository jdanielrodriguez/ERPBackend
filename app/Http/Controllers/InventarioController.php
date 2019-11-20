<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Inventario;
use App\Productos;
use DB;
use Response;
use Validator;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Inventario::with('productos')->get(), 200);
    }

    public function getThisByFilter(Request $request, $id,$state)
    {
        if($request->get('filter')){
            switch ($request->get('filter')) {
                case 'sucursal':{
                    $objectSee = Inventario::whereRaw('sucursal=?',[$state])->with('productos')->get();
                    break;
                }
                case 'productos':{
                    $objectSee = Inventario::whereRaw('productos=?',[$state])->with('productos')->get();
                    break;
                }
                default:{
                    $objectSee = Inventario::whereRaw('user=? and state=?',[$id,$state])->with('productos')->get();
                    break;
                }

            }
        }else{
            $objectSee = Inventario::with('productos')->get();
        }

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

    public function admin()
    {
        $objectSeeM = \DB::table('inventario')
        ->select('inventario.id','precioCosto','precioVenta','precioClienteEs','precioDistribuidor','cantidad','producto',
        'productos.nombre as productosnombre','productos.codigo as productoscodigo','productos.descripcion as productosdescripcion','productos.tipo','tiposproducto.descripcion as productostipodescripcion',
        DB::raw('(select proveedores.nombre from proveedores where proveedores.id = (select compras.proveedor from compras where compras.id=(select comprasdetalle.compra from comprasdetalle where comprasdetalle.producto=inventario.producto order by comprasdetalle.created_at desc limit 1) order by compras.fecha desc limit 1)) as proveedor'),
        DB::raw('(select compras.fecha from compras where compras.id=(select comprasdetalle.compra from comprasdetalle where comprasdetalle.producto=inventario.producto order by comprasdetalle.created_at desc  limit 1) order by compras.fecha desc limit 1) as fecha'),
        DB::raw('(select compras.comprobante from compras where compras.id=(select comprasdetalle.compra from comprasdetalle where comprasdetalle.producto=inventario.producto order by comprasdetalle.created_at desc limit 1) order by compras.fecha desc limit 1) as comprobante'))
        ->join('productos','productos.id','=','inventario.producto')
        ->join('tiposproducto','tiposproducto.id','=','productos.tipo')
        ->get();
        return Response::json($objectSeeM, 200);
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
            'nombre'          => 'required',
            'codigo'          => 'required',
            'tipo'            => 'required',
            'precioCosto'     => 'required',
            'precioVenta'     => 'required',
            'cantidad'        => 'required'
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
            if($request->get('id')){
                try {
                    $objectUpdate = Productos::whereRaw('id=?',[$request->get('id')])->first();
                    if ($objectUpdate) {
                        $newObject = new Inventario();
                        $newObject->producto           = $objectUpdate->id;
                        $newObject->precioCosto        = $request->get('precioCosto');
                        $newObject->precioVenta        = $request->get('precioVenta');
                        $newObject->precioClienteEs    = $request->get('precioClienteEs');
                        $newObject->precioDistribuidor = $request->get('precioDistribuidor');
                        $newObject->cantidad           = $request->get('cantidad');
                        $newObject->minimo             = $request->get('minimo');
                        $newObject->descuento          = $request->get('descuento');
                        $newObject->sucursal          = $request->get('sucursal');
                        $newObject->save();
                        $newObject->productos;
                        return Response::json($newObject, 200);
                    }
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
            }else{
                $objectUpdate = Productos::whereRaw('codigo=?',[$request->get('codigo')])->first();
                if ($objectUpdate) {
                    $returnData = array (
                        'status' => 402,
                        'message' => "El codigo ya existe"
                    );
                    return Response::json($returnData, 402);
                    try {
                        $objectUpdate->nombre      = $request->get('nombre', $objectUpdate->nombre);
                        $objectUpdate->descripcion = $request->get('descripcion', $objectUpdate->descripcion);
                        $objectUpdate->codigo      = $request->get('codigo', $objectUpdate->codigo);
                        $objectUpdate->marcaDes    = $request->get('marcaDes', $objectUpdate->marcaDes);
                        $objectUpdate->tipo        = $request->get('tipo', $objectUpdate->tipo);
                
                        $objectUpdate->save();
                        $objectActualiza = Inventario::whereRaw('producto=?',[$objectUpdate->id])->first();
                        if ($objectActualiza) {
                            try {
                                $objectActualiza->precioCosto        = $request->get('precioCosto', $objectActualiza->precioCosto);
                                $objectActualiza->precioVenta        = $request->get('precioVenta', $objectActualiza->precioVenta);
                                $objectActualiza->precioClienteEs    = $request->get('precioClienteEs', $objectActualiza->precioClienteEs);
                                $objectActualiza->precioDistribuidor = $request->get('precioDistribuidor', $objectActualiza->precioDistribuidor);
                                $objectActualiza->cantidad           = $request->get('cantidad', $objectActualiza->cantidad);
                                $objectActualiza->minimo             = $request->get('minimo', $objectActualiza->minimo);
                                $objectActualiza->descuento          = $request->get('descuento', $objectActualiza->descuento);
                                $objectActualiza->sucursal          = $request->get('sucursal', $objectActualiza->sucursal);
                                $objectActualiza->save();
                                $objectActualiza->productos;
                                return Response::json($objectActualiza, 200);
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
                    try {
                        $objectNuevo = new Productos();
                        $objectNuevo->nombre      = $request->get('nombre');
                        $objectNuevo->descripcion = $request->get('descripcion');
                        $objectNuevo->codigo      = $request->get('codigo');
                        $objectNuevo->marcaDes    = $request->get('marcaDes');
                        $objectNuevo->tipo        = $request->get('tipo');
                        $objectNuevo->save();
                            try {
                                $newObject = new Inventario();
                                $newObject->producto           = $objectNuevo->id;
                                $newObject->precioCosto        = $request->get('precioCosto');
                                $newObject->precioVenta        = $request->get('precioVenta');
                                $newObject->precioClienteEs    = $request->get('precioClienteEs');
                                $newObject->precioDistribuidor = $request->get('precioDistribuidor');
                                $newObject->cantidad           = $request->get('cantidad');
                                $newObject->minimo             = $request->get('minimo');
                                $newObject->descuento          = $request->get('descuento');
                                $newObject->sucursal          = $request->get('sucursal');
                                $newObject->save();
                                $newObject->productos;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objectSee = Inventario::with('productos')->find($id);
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
        $objectUpdate = Productos::whereRaw('codigo=? and id!=?',[$request->get('codigo'),$request->get('producto')])->first();
        if ($objectUpdate) {
            $returnData = array (
                'status' => 402,
                'message' => "El codigo ya existe"
            );
            return Response::json($returnData, 402);
        }else{
            $objectUpdate = Inventario::find($id);
            if ($objectUpdate) {
                try {
                    $objectUpdate->precioCosto        = $request->get('precioCosto', $objectUpdate->precioCosto);
                    $objectUpdate->precioVenta        = $request->get('precioVenta', $objectUpdate->precioVenta);
                    $objectUpdate->precioClienteEs    = $request->get('precioClienteEs', $objectUpdate->precioClienteEs);
                    $objectUpdate->precioDistribuidor = $request->get('precioDistribuidor', $objectUpdate->precioDistribuidor);
                    $objectUpdate->cantidad           = $request->get('cantidad', $objectUpdate->cantidad);
                    $objectUpdate->minimo             = $request->get('minimo', $objectUpdate->minimo);
                    $objectUpdate->descuento          = $request->get('descuento', $objectUpdate->descuento);
                    $objectUpdate->sucursal          = $request->get('sucursal', $objectUpdate->sucursal);
                    $objectUpdate->save();
                    $objectActualiza = Productos::find($request->get('producto'));
                    if ($objectActualiza) {
                        try {
                            $objectActualiza->nombre      = $request->get('nombre', $objectActualiza->nombre);
                            $objectActualiza->descripcion = $request->get('descripcion', $objectActualiza->descripcion);
                            $objectActualiza->codigo      = $request->get('codigo', $objectActualiza->codigo);
                            $objectActualiza->marcaDes    = $request->get('marcaDes', $objectActualiza->marcaDes);
                            $objectActualiza->tipo        = $request->get('tipo', $objectActualiza->tipo);
                    
                            $objectActualiza->save();
                            $objectUpdate->productos;
                            return Response::json($objectActualiza, 200);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objectDelete = Inventario::find($id);
        if ($objectDelete) {
            try {
                Inventario::destroy($id);
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