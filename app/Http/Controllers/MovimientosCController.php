<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\MovimientosC;
use App\CuentasCobrar;
use Response;
use Validator;

class MovimientosCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(MovimientosC::all(), 200);
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
            'abono'          => 'required',
            'descripcion'    => 'required',
            'cuentapagar'    => 'required'
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
                $objectUpdate = CuentasCobrar::find($request->get('cuentapagar'));
                if ($objectUpdate) {
                    try {
                        $objectUpdate->total = $objectUpdate->total-$request->get('abono');
                
                        $objectUpdate->save();
                        $newObject = new MovimientosC();
                        $newObject->credito          = $objectUpdate->total+$request->get('abono');
                        $newObject->abono            = $request->get('abono');
                        $newObject->saldo            = $objectUpdate->total;
                        $newObject->fecha            = $request->get('fecha');
                        $newObject->descripcion      = $request->get('descripcion');
                        $newObject->cuentacobrar      = $objectUpdate->id;
                        $newObject->save();
                        $objectUpdate->movimientos;
                        $objectUpdate->ventas;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objectSee = MovimientosC::find($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objectDelete = MovimientosC::find($id);
        if ($objectDelete) {
            try {
                MovimientosC::destroy($id);
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