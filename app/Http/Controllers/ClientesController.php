<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Clientes;
use Response;
use Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Clientes::all(), 200);
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
            'nombre'       => 'required',
            'nit'          => 'required',
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
                $newObject = new Clientes();
                $newObject->nombre            = $request->get('nombre');
                $newObject->apellido          = $request->get('apellido');
                $newObject->nit               = $request->get('nit');
                $newObject->direccion         = $request->get('direccion');
                $newObject->telefono          = $request->get('telefono');
                $newObject->celular           = $request->get('celular');
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
        $objectSee = Clientes::find($id);
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
        $objectUpdate = Clientes::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->nombre            = $request->get('nombre', $objectUpdate->nombre);
                $objectUpdate->apellido          = $request->get('apellido', $objectUpdate->apellido);
                $objectUpdate->nit               = $request->get('nit', $objectUpdate->nit);
                $objectUpdate->direccion         = $request->get('direccion', $objectUpdate->direccion);
                $objectUpdate->telefono          = $request->get('telefono', $objectUpdate->telefono);
                $objectUpdate->celular           = $request->get('celular', $objectUpdate->celular);
                $objectUpdate->estado            = $request->get('estado', $objectUpdate->estado);
                $objectUpdate->municipio         = $request->get('municipio', $objectUpdate->municipio);
                $objectUpdate->departamento      = $request->get('departamento', $objectUpdate->departamento);
                $objectUpdate->pais              = $request->get('pais', $objectUpdate->pais);
                
                $objectUpdate->save();
                $objectUpdate->function;
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
        $objectDelete = Clientes::find($id);
        if ($objectDelete) {
            try {
                Clientes::destroy($id);
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
