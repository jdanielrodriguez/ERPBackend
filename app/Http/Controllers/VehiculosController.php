<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Vehiculos;
use Response;
use Validator;

class VehiculosController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Response::json(Vehiculos::all(), 200);
    }
    
    public function getThisByFilter(Request $request, $id,$state)
    {
        if($request->get('filter')){
            switch ($request->get('filter')) {
                case 'placa':{
                    $objectSee = Vehiculos::whereRaw('placa=?',[$state])->with('clientes')->get();
                    break;
                }
                case 'modelo':{
                    $objectSee = Vehiculos::whereRaw('modelo=?',[$state])->with('clientes')->get();
                    break;
                }
                case 'cliente':{
                    $objectSee = Vehiculos::whereRaw('cliente=?',[$id])->with('clientes')->get();
                    break;
                }
                default:{
                    $objectSee = Vehiculos::whereRaw('cliente=?',[$id])->with('clientes')->get();
                    break;
                }
    
            }
        }else{
            $objectSee = Vehiculos::with('clientes')->get();
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

    public function getThisByClient($id)
    {
        $objectSee = Vehiculos::where('cliente','=',$id)->with('clientes')->get();
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
            'cliente'          => 'required',
            'placa'          => 'required',
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
                $newObject = new Vehiculos();
                $newObject->placa            = $request->get('placa');
                $newObject->modelo            = $request->get('modelo');
                $newObject->serie            = $request->get('serie');
                $newObject->entrega            = $request->get('entrega');
                $newObject->comentario            = $request->get('comentario');
                $newObject->fechaMantenimiento            = $request->get('fechaMantenimiento');
                $newObject->fechaSiguienteMantenimiento            = $request->get('fechaSiguienteMantenimiento');
                $newObject->mantenimiento            = $request->get('mantenimiento');
                $newObject->estado            = $request->get('estado');
                $newObject->cliente            = $request->get('cliente');
                $newObject->save();
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
        $objectSee = Vehiculos::find($id);
        if ($objectSee) {
            $objectSee->clientes;
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
        $objectUpdate = Vehiculos::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->placa = $request->get('placa', $objectUpdate->placa);
                $objectUpdate->modelo = $request->get('modelo', $objectUpdate->modelo);
                $objectUpdate->serie = $request->get('serie', $objectUpdate->serie);
                $objectUpdate->entrega = $request->get('entrega', $objectUpdate->entrega);
                $objectUpdate->comentario = $request->get('comentario', $objectUpdate->comentario);
                $objectUpdate->fechaMantenimiento = $request->get('fechaMantenimiento', $objectUpdate->fechaMantenimiento);
                $objectUpdate->fechaSiguienteMantenimiento = $request->get('fechaSiguienteMantenimiento', $objectUpdate->fechaSiguienteMantenimiento);
                $objectUpdate->mantenimiento = $request->get('mantenimiento', $objectUpdate->mantenimiento);
                $objectUpdate->estado = $request->get('estado', $objectUpdate->estado);
                $objectUpdate->cliente = $request->get('cliente', $objectUpdate->cliente);
                $objectUpdate->save();
                $objectUpdate->clientes;
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
    }
    
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $objectDelete = Vehiculos::find($id);
        if ($objectDelete) {
            try {
                Vehiculos::destroy($id);
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
