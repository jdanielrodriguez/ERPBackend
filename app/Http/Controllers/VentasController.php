<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ventas;
use App\VentasDetalle;
use App\Inventario;
use App\CuentasCobrar;
use Response;
use DB;
use Validator;
use PHPShopify;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Ventas::where('estado','=','1')->with('clientes','tipos')->get(), 200);
    }

    public function anuladas()
    {
        return Response::json(Ventas::where('estado','=','0')->with('clientes','tipos')->get(), 200);
    }

    public function comprobante()
    {
        $objectSee = Ventas::orderby('id','desc')->first();
        if ($objectSee) {
            $objectSee->clientes;
            return Response::json($objectSee, 200);
        
        }
        else {
            $myObject = (object) array("comprobante" => 0);
            return Response::json($myObject, 200);
        }
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
    
    public function Ordenes()
    {
        $config = array(
            'ShopUrl' => 'guatedirect.myshopify.com',
            'ApiKey' => 'c811a2b2e74dfb273ab0f499e82974f1',
            'Password' => '4a85141b78c49844c3d17dbcb1d0787b',
        );
        $shopify = new PHPShopify\ShopifySDK($config);
        $products = $shopify->Order->get();
        return Response::json($products, 200);

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
            'cliente'        => 'required',
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
                $newObject = new Ventas();
                $newObject->cliente              = $request->get('cliente');
                $newObject->usuario              = $request->get('usuario');
                $newObject->total                = $request->get('total');
                $newObject->fecha                = $request->get('fecha');
                $newObject->tipo                 = $request->get('tipo');
                $newObject->comprobante          = $request->get('comprobante');
                $newObject->save();
                if($newObject->tipo==2 || $newObject->tipo=='2'){
                    $newCount = new CuentasCobrar();
                    $newCount->creditoDado            = $request->get('total');
                    $newCount->total                  = $request->get('total');
                    $newCount->plazo                  = $request->get('plazo');
                    $newCount->tipoPlazo              = $request->get('tipoPlazo');
                    $newCount->venta                  = $newObject->id;
                    $newCount->save();
                }
                if ( $request->get('detalle') )
                {
                   $Array = $request->get('detalle');
                   foreach ($Array as $value)
                    {
                        $objectUpdate = Inventario::find($value['id']);
                        if ($objectUpdate) {
                            try {
                                if(($objectUpdate->cantidad*1)>=($value['cantidad']*1)){
                                    $objectUpdate->cantidad           = (($objectUpdate->cantidad-$value['cantidad']));
                                    $objectUpdate->save();
                                    $registro = new VentasDetalle();
                                    $registro->subtotal    = $value['subtotal'];
                                    $registro->cantidad    = $value['cantidad'];
                                    $registro->precio      = $value['precioVenta'];
                                    $registro->precioE     = $value['precioClienteEs'];
                                    $registro->precioM     = $value['precioDistribuidor'];
                                    $registro->venta       = $newObject->id;
                                    $registro->producto    = $value['producto'];
                                    $registro->tipo        = $newObject->tipo;
                                    $registro->save();
                                }else{
                                    DB::rollback();
                                    $returnData = array (
                                        'status' => 401,
                                        'message' => 'No hay Existencias suficientes',
                                        'existe' => $objectUpdate->cantidad,
                                        'cantidad' => $value['cantidad']
                                    );
                                    return Response::json($returnData, 401);
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
        $objectSee = Ventas::with('detalle','clientes','tipos')->find($id);
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
    
    public function ventasByClient($id)
    {
        $objectSee = Ventas::whereRaw('cliente=?',$id)->with('detalle','clientes','tipos')->get();
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

    public function estadisticaVendedoresBarra(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventas.total) as total'),'usuarios.username','ventas.fecha')
        ->join('usuarios', 'usuarios.id', '=', 'ventas.usuario')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        ->groupBy('usuarios.username')
        ->groupBy(DB::raw('date(ventas.fecha)'))
        ->get();
        
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

    public function estadisticaClientesBarra(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventas.total) as total'),'clientes.nombre','clientes.apellido','ventas.fecha')
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        ->groupBy('clientes.nombre','clientes.apellido')
        ->groupBy(DB::raw('date(ventas.fecha)'))
        ->get();
        
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

    public function estadisticaVentasBarra(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventas.total) as total'),'ventas.fecha')
        // ->join('clientes', 'clientes.id', '=', 'ventas.cliente')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        // ->groupBy('clientes.nombre','clientes.apellido')
        ->groupBy(DB::raw('date(ventas.fecha)'))
        ->get();
        
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

    public function estadisticaVentasPie(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventasdetalle.cantidad) as total'),'ventasdetalle.subtotal','ventas.fecha','productos.nombre')
        ->join('ventasdetalle', 'ventasdetalle.venta', '=', 'ventas.id')
        ->join('productos', 'productos.id', '=', 'ventasdetalle.producto')
        ->join('usuarios', 'usuarios.id', '=', 'ventas.usuario')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        ->groupBy('productos.id')
        ->orderby(DB::raw('sum(ventasdetalle.cantidad)'),'desc')
        ->limit(5)
        ->get();
        //$sql = "SELECT (dv.subtotal),sum(dv.cantidad),p.nombre,p.codigoproducto,p.tiporepuesto FROM ventas v  
        // inner join ventasdetalle dv on dv.idventa=v.idventas 
        // inner join productos p on p.idproductos=dv.idproductos 
        // inner join usuarios u on v.idusuario=u.idusuarios 
        // where (v.fecha>'".$datos[0]."' and v.fecha<'".$fecha3."') and v.estado=1 
        // group by p.idproductos order by sum(dv.cantidad) desc limit 5;";
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

    public function estadisticaClientesPie(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventas.total) as total'),'clientes.nombre','clientes.apellido','ventas.fecha')
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        ->groupBy('clientes.nombre','clientes.nombre')
        ->get();
        
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

    public function estadisticaVendedoresPie(Request $request){
        $objectSee = \DB::table('ventas')
        ->select(DB::raw('sum(ventas.total) as total'),'usuarios.username','ventas.fecha')
        ->join('usuarios', 'usuarios.id', '=', 'ventas.usuario')
        ->whereRaw('(ventas.fecha>=? and ventas.fecha<=?) and ventas.estado=1',[$request->get('fechaInicio'),$request->get('fechaFin')])
        ->groupBy('usuarios.username')
        ->get();
        
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
        DB::beginTransaction();
        $objectUpdate = Ventas::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->estado = $request->get('estado', $objectUpdate->estado);
                if($objectUpdate->tipo==2 || $objectUpdate->tipo=='2'){
                    $objectDelete = CuentasCobrar::whereRaw('venta=?',[$objectUpdate->id])->first();
                    if ($objectDelete) {
                        try {
                            CuentasCobrar::destroy($objectDelete->id);
                        } catch (Exception $e) {
                            DB::rollback();
                            $returnData = array (
                                'status' => 500,
                                'message' => $e->getMessage()
                            );
                            return Response::json($returnData, 500);
                        }
                    }
                    else {
                        DB::rollback();
                        $returnData = array (
                            'status' => 404,
                            'message' => 'No record found'
                        );
                        return Response::json($returnData, 404);
                    }
                }
                $objectUpdate->save();
                $objectUpdate2 = VentasDetalle::whereRaw('venta=?',$id)->get();
                if ($objectUpdate2) {
                    try {
                        foreach ($objectUpdate2 as $value) {
                            $actualiza = VentasDetalle::find($value['id']);
                            if ($actualiza) {
                                try {
                                    $actualiza->estado = $request->get('estado', $actualiza->estado);
                                        $inventario = Inventario::whereRaw('producto=?',[$actualiza->producto])->first();
                                        if ($inventario) {
                                            $inventario->cantidad = $inventario->cantidad+$actualiza->cantidad;
                                            $inventario->save();
                                        }
                                    $actualiza->save();
                                } catch (Exception $e) {
                                    DB::rollback();
                                    $returnData = array (
                                        'status' => 500,
                                        'message' => $e->getMessage()
                                    );
                                    return Response::json($returnData, 500);
                                }
                            }
                            else {
                                DB::rollback();
                                $returnData = array (
                                    'status' => 404,
                                    'message' => 'No record found'
                                );
                                return Response::json($returnData, 404);
                            }
                        }
                        DB::commit();
                        return Response::json($objectUpdate, 200);
                    } catch (Exception $e) {
                        DB::rollback();
                        $returnData = array (
                            'status' => 500,
                            'message' => $e->getMessage()
                        );
                        return Response::json($returnData, 500);
                    }
                }
                else {
                    DB::rollback();
                    $returnData = array (
                        'status' => 404,
                        'message' => 'No record found'
                    );
                    return Response::json($returnData, 404);
                }
            } catch (Exception $e) {
                DB::rollback();
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
        else {
            DB::rollback();
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
        $objectDelete = Ventas::find($id);
        if ($objectDelete) {
            try {
                Ventas::destroy($id);
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