<?php

namespace App\Http\Controllers;

use App\Candidates;
use App\Lists;
use App\Votes;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\JwtAuth;
use App\User;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Exists;

class ListController extends Controller
{
    //.
    public function __construct()
    {
        $this->middleware('api.auth', ['except' =>
        [
            'pruebas',
            'getLists',
            'getCanByList',
            'countList',
            'getImage',
            'getListById',
            'getListsVotes'
            
        ]]);
    }

    
    public function getLists()
    {

        $lists = Lists::all();




        return response()->json([

            'status'    =>  'success',
            'code'      =>  200,
            'lists'      =>  $lists

            //$user->name = $params_array['name'];

        ]);
    }

    public function getListsVotes()
    {

      //  $lists = Lists::all();
        $lists = Lists::orderBy('numVote', 'DESC')->get();




        return response()->json([

            'status'    =>  'success',
            'code'      =>  200,
            'lists'      =>  $lists

            //$user->name = $params_array['name'];

        ]);
    }



    public function storeList(Request $request)
    {
        //Recoger datos de usuario por post

        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array


        //validar datos

        if (!empty($params) && !empty($params_array)) {


            $validate = \Validator::make($params_array, [
                'listdescription'     =>  'required',
                'image'               =>  'required',


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
                $list = new Lists();
              //  $vote = new Votes();

                //  $post->user_id = $params->user_id;
                $list->listdescription = $params_array['listdescription'];
                $list->image = $params_array['image'];
                $list->numVote = 0;


               




                //guardar post

                $list->save();


//$vote->idList = $list->id;
          //      $vote->numVote = 0;

            //    $vote->save();


                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'Registro Exitoso',
                    'list'      => $list
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



        
        
    public function update($id, Request $request)
{
    //recoger datos por post
    $json = $request->input('json', null);
    $params = json_decode($json);
    $params_array = json_decode($json, true);

    $list = Lists::find($id);


  

    if (!empty($list)) {

        if (!empty($params_array)) {

            // actualizar post



            // validar datos

            $validate = \Validator::make($params_array, [

                'listdescription'     =>  'required',
                'image'               =>  'required'

            ]);

            // quitar campos que no quiero actualizar

            unset($params_array['id']);
            unset($params_array['created_at']);
            unset($params_array['numVote']);



            // actualizar categoria en bbdd

            $list_update = Lists::where('id', $id)->update($params_array);



            //devolver array

            $data = array(
                'status'    =>  'success',
                'code'      =>  200,
                'list'  =>  $list_update,
                'changes'   =>  $params_array

            );
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'message'   =>  'No has enviado ninguna lista'

            );
        }
    } else {

        $data = array(
            'status'    =>  'error',
            'code'      =>  400,
            'message'   =>  'No existe la lista'

        );
    }


    return response()->json($data, $data['code']);
}
        


    
        //los post seran eliminados por usuario que lo creó
        public function destroy($id, Request $request)
        {


                $list = Lists::where('id', $id)->first();
                $listCan = Candidates::where('idList', $id)->first();

                if(!empty($listCan)) {
                    $data = array(
                        'status'    =>  'error',
                        'code'      =>  201,
                        'message'   =>  'Relacion con candidato'
        
                    );


                } else { 

    
                if (!empty($list)) {
        
                    $list->delete();
        
                    $data = array(
                        'status'    =>  'success',
                        'code'      =>  200,
                        'message'   =>  'lista eliminada',
                        'list'      =>  $list
        
                    );
                } else {
        
                    $data = array(
                        'status'    =>  'error',
                        'code'      =>  400,
                        'message'   =>  'No existe esta lista'
        
                    );
                }

            }

                
            
    
           
    
            return response()->json($data, $data['code']);
        }


        public function getListById($id)
    {

       
        $list = Lists::find($id);
        //$canti = $candidates::count();
    
            $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'list'   =>  $list
                    
                    

                );
            

        return response()->json($data, $data['code']);
    }

    public function updateVoteUser(Request $request){

         //recoger datos por post
         $json = $request->input('json', null);
         $params = json_decode($json);
         $params_array = json_decode($json, true);

        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        
        $userId = $user->sub;
        
        $getUser = User::find($userId);


        if (!empty($getUser)) {



            if (!empty($params_array)) {
           

                $validate = \Validator::make($params_array, [

                    'vote'         =>  'required'
                   

                ]);

                // quitar campos que no quiero actualizar

                unset($params_array['id']);
                unset($params_array['identification_card']);
                unset($params_array['name']);
                unset($params_array['lastname']);
                unset($params_array['email']);
                unset($params_array['password']);
                unset($params_array['imageProfile']);
                unset($params_array['idRole']);
                unset($params_array['idStudy']);
                unset($params_array['created_at']);


              

                


                    //actualizar registro en concreto

                    $getUser->update($params_array);



                    //devolver array

                    $data = array(
                        'status'    =>  'success',
                        'code'      =>  200,
                        'user'  =>  $getUser,
                        'changes'   =>  $params_array

                    );
              

                

            } else {

                $data = array(
                    'status'    =>  'error',
                    'code'      =>  400,
                    'message'   =>  'No has enviado ningun dato'

                );
            }
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'mesaage'   =>  'No existe la entrada'

            );
        }


        return response()->json($data, $data['code']);
    }




    
    
    public function votar($id, Request $request)
    {
        //recoger datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
    

        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        
        $userId = $user->sub;
        
        $list = Lists::find($id);
           
    
        if (!empty($list)) {
    
            if (!empty($params_array)) {
    
                // actualizar post
    
    
    
                // validar datos
    
                $validate = \Validator::make($params_array, [
    
                    'numVote'     =>  'required',
    
                ]);
    
                // quitar campos que no quiero actualizar
    
                unset($params_array['id']);
                unset($params_array['listdescription']);
                unset($params_array['created_at']);
                unset($params_array['image']);
                
    
    
    
                // actualizar categoria en bbdd
    
                $list_update = Lists::where('id', $id)->update($params_array);
    
    
    
                //devolver array
    
                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'list'  =>  $list_update,
                    'changes'   =>  $params_array
    
                );
            } else {
    
                $data = array(
                    'status'    =>  'error',
                    'code'      =>  400,
                    'message'   =>  'No has enviado ninguna lista'
    
                );
            }
        } else {
    
            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'message'   =>  'No existe la lista'
    
            );
        }
    
    
        return response()->json($data, $data['code']);
    }
            
    
    


}
