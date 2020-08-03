<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;


class UserController extends Controller
{
    //
    


    public function login(Request $request)
    {


        $jwtAuth = new \JwtAuth();

        //Recibir datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true); // array

 

        //validar datos

        if (!empty($params) && !empty($params_array)) {


            $validate = \Validator::make($params_array, [

                'email'      =>  'required|email|',
                'password'   =>  'required'
            ]);
        }

        if ($validate->fails()) {

            $signup = array(
                'status'    =>  'error',
                'code'      =>  404,
                'message'   =>    'El usuario no se ha podido loguear',
                'errors'    =>  $validate->errors()
            );
        } else {


            //devolver token o datos
            $signup =  $jwtAuth->signup($params->email, $params->password);

            if (!empty($params->gettoken)) {

                $signup =  $jwtAuth->signup($params->email, $params->password, true);
            }
        }

        return response()->json($signup, 200);
    }




    
public function UserById($id)
{

    $user = User::find($id);

    if (is_object($user)) {

        $data = array(
            'status'    =>  'success',
            'code'      =>  200,
            'user'      =>  $user

        );
    } else {

        $data = array(
            'status'    =>  'error',
            'code'      =>  400,
            'mesaage'   =>  'El usuario no existe'

        );
    }

    return response()->json($data, $data['code']);
}


}
