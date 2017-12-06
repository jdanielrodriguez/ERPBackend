<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Usuarios;
use Response;
use Validator;
use Hash;
use Storage;
use Faker\Factory as Faker;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Usuarios::with('empleados')->get(), 200);
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
            'username'          => 'required',
            'password'          => 'required|min:3|regex:/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-,:-@]).*$/',
            'email'          => 'required|email'
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
            $email = $request->get('email');
            $email_exists  = Usuarios::whereRaw("email = ?", $email)->count();
            $user = $request->get('username');
            $user_exists  = Usuarios::whereRaw("username = ?", $user)->count();
            if($email_exists == 0 && $user_exists == 0){
                try {
                    $newObject = new Usuarios();
                    $newObject->username         = $request->get('username');
                    $newObject->password         = Hash::make($request->get('password'));
                    $newObject->email            = $request->get('email');
                    $newObject->rol              = $request->get('rol');
                    $newObject->privileges       = $request->get('privileges');
                    $newObject->empleado         = $request->get('empleado');
                    $newObject->sucursal         = $request->get('sucursal');
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
            } else {
                $returnData = array(
                    'status' => 400,
                    'message' => 'User already exists',
                    'validator' => $validator->messages()->toJson()
                );
                return Response::json($returnData, 400);
            }
        }
    }
    public function recoveryPassword(Request $request){
        $objectUpdate = Usuarios::whereRaw('email=? or username=?',[$request->get('username'),$request->get('username')])->with('empleados')->first();
        if ($objectUpdate) {
            try {
                $faker = Faker::create();
                $pass = $faker->password();
                $objectUpdate->password = bcrypt($pass);
                $objectUpdate->estado = 2;
                
                Mail::send('emails.recovery', ['empresa' => 'FoxyLabs', 'url' => 'https://foxylabs.gt', 'password' => $pass, 'email' => $objectUpdate->email, 'name' => $objectUpdate->empleados->nombre.' '.$objectUpdate->empleados->apellido,], function (Message $message) use ($objectUpdate){
                    $message->from('info@foxylabs.gt', 'Info FoxyLabs')
                            ->sender('info@foxylabs.gt', 'Info FoxyLabs')
                            ->to($objectUpdate->email, $objectUpdate->empleados->nombre.' '.$objectUpdate->empleados->apellido)
                            ->replyTo('info@foxylabs.gt', 'Info FoxyLabs')
                            ->subject('Contraseña Reestablecida');
                
                });
                
                $objectUpdate->save();
                
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
    public function changePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'new_pass' => 'required|min:3|regex:/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-,:-@]).*$/',
            'old_pass'      => 'required'
        ]);

        if ($validator->fails()) {
            $returnData = array(
                'status' => 400,
                'message' => 'Invalid Parameters',
                'validator' => $validator->messages()->toJson()
            );
            return Response::json($returnData, 400);
        }
        else {
            $old_pass = $request->get('old_pass');
            $new_pass_rep = $request->get('new_pass_rep');
            $new_pass =$request->get('new_pass');
            $objectUpdate = Usuarios::find($id);
            if ($objectUpdate) {
                try {
                    if(Hash::check($old_pass, $objectUpdate->password))
                    {                       
                        if($new_pass_rep != $new_pass)
                        {
                            $returnData = array(
                                'status' => 404,
                                'message' => 'Passwords do not match'
                            );
                            return Response::json($returnData, 404);
                        }

                        if($old_pass == $new_pass)
                        {
                            $returnData = array(
                                'status' => 404,
                                'message' => 'New passwords it is same the old password'
                            );
                            return Response::json($returnData, 404);
                        }
                        $objectUpdate->password = Hash::make($new_pass);
                        $objectUpdate->estado = 1;
                        $objectUpdate->save();

                        return Response::json($objectUpdate, 200);
                    }else{
                        $returnData = array(
                            'status' => 404,
                            'message' => 'Invalid Password'
                        );
                        return Response::json($returnData, 404);
                    }
                }
                catch (Exception $e) {
                    $returnData = array(
                        'status' => 500,
                        'message' => $e->getMessage()
                    );
                }
            }
            else {
                $returnData = array(
                    'status' => 404,
                    'message' => 'No record found'
                );
                return Response::json($returnData, 404);
            }
        }
    }
    public function uploadAvatar(Request $request, $id) {
        $objectUpdate = Usuarios::find($id);
        if ($objectUpdate) {

            $validator = Validator::make($request->all(), [
                'avatar'      => 'required|image|mimes:jpeg,png,jpg'
            ]);

            if ($validator->fails()) {
                $returnData = array(
                    'status' => 400,
                    'message' => 'Invalid Parameters',
                    'validator' => $validator->messages()->toJson()
                );
                return Response::json($returnData, 400);
            }
            else {
                try {
                    $path = Storage::disk('s3')->put('avatars', $request->avatar);

                    $objectUpdate->picture = Storage::disk('s3')->url($path);
                    $objectUpdate->save();

                    return Response::json($objectUpdate, 200);
                }
                catch (Exception $e) {
                    $returnData = array(
                        'status' => 500,
                        'message' => $e->getMessage()
                    );
                }

            }

            return Response::json($objectUpdate, 200);
        }
        else {
            $returnData = array(
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
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
        $objectSee = Usuarios::find($id);
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
        $objectUpdate = Usuarios::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->username         = $request->get('username', $objectUpdate->username);
                $objectUpdate->email            = $request->get('email', $objectUpdate->email);
                $objectUpdate->rol              = $request->get('rol', $objectUpdate->rol);
                $objectUpdate->empleado         = $request->get('empleado', $objectUpdate->empleado);
                $objectUpdate->sucursal         = $request->get('sucursal', $objectUpdate->sucursal);
                $objectUpdate->privileges       = $request->get('privileges', $objectUpdate->privileges);
                $objectUpdate->estado           = $request->get('estado', $objectUpdate->estado);
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
        $objectDelete = Usuarios::find($id);
        if ($objectDelete) {
            try {
                Usuarios::destroy($id);
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
