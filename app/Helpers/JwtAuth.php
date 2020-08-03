<?php

namespace App\Helpers;

//require_once "vendor/autoload.php";

use App\User;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Firebase\JWT\JWT;


class JwtAuth
{

    public $key;

    public function __construct(){
        
        $this->key = 'clave_token_votaciones_2020_uleam';
    }


    public function signup($email, $password,$getToken=null)
    {

        // buscar si existe el usuario
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        //comprobar si son correctas
        $signup = false;

        if (is_object($user)) {
            $signup = true;
        }

        //generar token
        if ($signup) {
          
            $token = array(
                'sub'        =>      $user->id,
                'card'       =>      $user->identification_card,
                'email'      =>      $user->email,
                'name'       =>      $user->name,
                'lastname'   =>      $user->lastname,
                'image'      =>      $user->imageProfile,
                'role'       =>      $user->role->typeRole,
                'career'     =>      $user->study->career->nameCareer,
                'semester'   =>      $user->study->semester->numSemester,
                'iat'        =>      time(),
                'exp'        =>      time() + (7 * 24 * 60 * 60),
                'vote'       =>      $user->vote
 

            );
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);

            if (is_null($getToken)) {
                $data = $jwt;
            } else {
                $data = $decoded;
            }
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'login incorrect'
            );
        }

        //devolver datos decodificados o token


        return $data;
    }


//comprobar si el token es correcto 
public function checkToken($jwt, $getIdentity = false){

    $auth = false;

    try {
        $jwt = str_replace('"', '', $jwt);
        $decoded = JWT::decode($jwt, $this->key, ['HS256']);
    } catch (\UnexpectedValueException $e) {    
        $auth = false;
    } catch (\DomainException $e){
        $auth = false;
    }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){

            $auth = true;

        }else {

            $auth = false;

        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;


}





}
