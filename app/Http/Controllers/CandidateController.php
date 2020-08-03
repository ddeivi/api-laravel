<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Candidates;
use App\Lists;


use App\User;
use Illuminate\Http\Response;
use App\Helpers\JwtAuth;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Exists;


class CandidateController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('api.auth', ['except' =>
        [
            'pruebas',
            'getCandidates',
            'getCanByList',
            'countList',
            'create',
            'getImage'
            

        ]]);
    }



    public function pruebas(Request $request)
    {

        return 'candidates controller';
    }


    public function storeCandidate(Request $request)
    {
        //Recoger datos de usuario por post

        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array


        //datos de usuario

        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);




        //validar datos

        if (!empty($params) && !empty($params_array)) {


            $validate = \Validator::make($params_array, [
                'name'                =>  'required',
                'lastname'            =>  'required',
                'image'               =>  'required',
                'idTypeCandidate'     =>  'required',
                'idList'              =>  'required'


            ]);


            if ($validate->fails()) {

                $data = array(
                    'status'    =>  'error',
                    'code'      =>  404,
                    'mesaage'   =>  'El registro no se ha realizado',
                    'errors'    =>  $validate->errors()
                );
            } else {

                //crear post
                $candidate = new Candidates();

                //  $post->user_id = $params->user_id;
                $candidate->name = $params_array['name'];
                $candidate->lastname = $params_array['lastname'];
                $candidate->image = $params_array['image'];
                $candidate->idTypeCandidate = $params_array['idTypeCandidate'];
                $candidate->idList = $params_array['idList'];




                //guardar post

                $candidate->save();

                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'Registro Exitoso',
                    'candidate'      => $candidate
                );
            }
        } else {


            $data = array(
                'status'    =>  'error',
                'code'      =>   400,
                'message'   =>  'los datos enviados no son correctos'
            );
        }


        return response()->json($data, $data['code']);;
    }



    public function upload(Request $request)
    {

        // recoger datos de la peticion
        $image = $request->file('file0');

        //validar imagen 

        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if (!$image || $validate->fails()) {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'mesaage'   =>  'Error al subir imagen'

            );
        } else {

            //guardar imagen

            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('images')->put($image_name, \File::get($image));

            //devolver respuesta    

            $data = array(
                'status'    =>  'success',
                'code'      =>  200,
                'image'   =>  $image_name

            );
        }

        //return   response($data, $data['code'])->header('Content-Type', 'text/plain');
        return $data = response()->json($data, $data['code']);
        //   return response()->json($data,200);
    }

    public function getImage($fileName)
    {
        //comprobar si existe el fichero
        $isset = \Storage::disk('images')->exists($fileName);

        if ($isset) {

            //conseguir la imagen
            $file = \Storage::disk('images')->get($fileName);

            //devolver imagen
            return new Response($file, 200);
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'mesaage'   =>  'La imagen no existe'

            );

            return response()->json($data, $data['code']);
        }
    }






    public function getCandidates()
    {

        $candidates = Candidates::all()->load('list')
            ->load('type');






        return response()->json([

            'status'    =>  'success',
            'code'      =>  200,
            'candidates'      =>  $candidates

            //$user->name = $params_array['name'];

        ]);
    }

    public function getCanByList($id)
    {


        $candidates = Candidates::where('idList', $id)->get()->load('list')->load('type');
        //$canti = $candidates::count();

        $data = array(
            'status'    =>  'success',
            'code'      =>  200,
            'candidates'   =>  $candidates



        );


        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {
        //recoger datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        $candidate = Candidates::find($id);






        if (!empty($candidate)) {

            if (!empty($params_array)) {

                // actualizar post



                // validar datos

                $validate = \Validator::make($params_array, [

                    'name'                =>  'required',
                    'lastname'            =>  'required',
                    'image'               =>  'required',
                    'idTypeCandidate'     =>  'required',
                    'idList'              =>  'required'

                ]);

                // quitar campos que no quiero actualizar

                unset($params_array['id']);
                unset($params_array['created_at']);


                // actualizar categoria en bbdd

                $candidate_update = Candidates::where('id', $id)->update($params_array);



                //devolver array

                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'candidate'  =>  $candidate_update,
                    'changes'   =>  $params_array

                );
            } else {

                $data = array(
                    'status'    =>  'error',
                    'code'      =>  400,
                    'message'   =>  'No has enviado ninguna dato'

                );
            }
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'message'   =>  'No existe el candidato'

            );
        }


        return response()->json($data, $data['code']);
    }




    public function destroy($id, Request $request)
    {


        $candidate = Candidates::where('id', $id)->first();

        if (!empty($candidate)) {

            $candidate->delete();

            $data = array(
                'status'    =>  'success',
                'code'      =>  200,
                'message'   =>  'candidato eliminado',
                'candidate'      =>  $candidate

            );
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'message'   =>  'No existe este candidato'

            );
        }





        return response()->json($data, $data['code']);
    }



    public function getCandidateById($id)
    {


        $candidate = Candidates::find($id);

        $data = array(
            'status'    =>  'success',
            'code'      =>  200,
            'candidate'      =>  $candidate



        );


        return response()->json($data, $data['code']);
    }
}
