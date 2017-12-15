<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Accesos;
use App\Modulos;
use Response;
use DB;
use Validator;

class AccesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Accesos::all(), 200);
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
            'usuario'          => 'required',
            'modulo'           => 'required'
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
            $objectUpdate = Accesos::whereRaw('modulo=? and usuario=?',[$request->get('modulo'),$request->get('usuario')])->first();
            if ($objectUpdate) {
                try {
                    
                    $objectUpdate->agregar   = $request->get('agregar', $objectUpdate->agregar);
                    $objectUpdate->eliminar  = $request->get('eliminar', $objectUpdate->eliminar);
                    $objectUpdate->modificar = $request->get('modificar', $objectUpdate->modificar);
                    $objectUpdate->mostrar   = $request->get('mostrar', $objectUpdate->mostrar);
                    $objectUpdate->save();
                    if($objectUpdate->agregar==0 && $objectUpdate->eliminar==0 && $objectUpdate->modificar==0 && $objectUpdate->mostrar==0){
                        $objectDelete = Accesos::find($objectUpdate->id);
                        if ($objectDelete) {
                            try {
                                Accesos::destroy($objectUpdate->id);
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
                try {
                    $newObject = new Accesos();
                    $newObject->agregar            = $request->get('agregar',0);
                    $newObject->eliminar           = $request->get('eliminar',0);
                    $newObject->modificar          = $request->get('modificar',0);
                    $newObject->mostrar            = $request->get('mostrar',0);
                    $newObject->usuario            = $request->get('usuario');
                    $newObject->modulo             = $request->get('modulo');
                    $newObject->save();
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
        $objectSee = Accesos::find($id);
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

    public function getAccesos($id)
    {
        $objectSee = Accesos::select('modulo')->whereRaw('usuario=?',[$id])->orderby('modulo')->get();
        if ($objectSee) {
            // $objectSeeM = Modulos::whereIn('id',$objectSee)->with('accesos')->where('estado','=','1')->where('accesos.usuario','=',$id)->get();
            $objectSeeM = \DB::table('modulos')
            ->select('id','nombre','tipo','refId','dir','link','icono',
            DB::raw('(select agregar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as agregar'),
            DB::raw('(select modificar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as modificar'),
            DB::raw('(select mostrar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as mostrar'),
            DB::raw('(select eliminar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as eliminar'))
            ->whereIn('modulos.id',$objectSee)
            ->where('modulos.estado', '=', '1')
            ->where('modulos.tipo', '=', '1')
            ->orderby('orden')
            ->get();
            $objectSeeP = \DB::table('modulos')
            ->select('id','nombre','tipo','refId','dir','link','icono',
            DB::raw('(select agregar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as agregar'),
            DB::raw('(select modificar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as modificar'),
            DB::raw('(select mostrar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as mostrar'),
            DB::raw('(select eliminar from accesos where accesos.modulo = modulos.id and accesos.usuario = '.$id.' order by accesos.deleted_at  limit 1) as eliminar'))
            ->whereIn('modulos.id',$objectSee)
            ->where('modulos.estado', '=', '1')
            ->where('modulos.tipo', '=', '0')
            ->orderby('orden')
            ->get();
            $myObject = (object) array("permitidos" => [], "ocultos" => []);
            $myObject->permitidos = $objectSeeP;
            $myObject->ocultos    = $objectSeeM;
            return Response::json($myObject, 200);
        
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }

    public function getAcceso($id,$id2)
    {
        $objectSee = Accesos::where('modulo','=',$id2)->where('usuario','=',$id)->first();
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
        $objectDelete = Accesos::find($id);
        if ($objectDelete) {
            try {
                Accesos::destroy($id);
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
