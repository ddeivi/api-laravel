<?php

namespace App\Http\Controllers;

use App\Votes;
use App\Lists;



use Illuminate\Http\Request;

class VotesController extends Controller
{
    //
    public function storeVote(Request $request)
    {
        //Recoger datos de usuario por post

        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array


        //validar datos

        if (!empty($params) && !empty($params_array)) {


            $validate = \Validator::make($params_array, [
                'numVote'     =>  'required',
                'idList'     =>  'required'


            ]);


            if ($validate->fails()) {

                $data = array(
                    'status'    =>  'error',
                    'code'      =>  404,
                    'mesaage'   =>  'El registro no se ha realizado',
                    'errors'    =>  $validate->errors()
                );
            } else {

                //votar
                $vote = new Votes();

                //  $post->user_id = $params->user_id;
                $vote->idList = $params_array['idList'];
                $vote->numVote = $params_array['numVote'];
               




                //guardar 

                $vote->save();

                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'Registro Exitoso',
                    'vote'      => $vote
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
    

    public function getVotesByList($id)
    {


       // $votes = Votes::where('idList', $id)->get()->load('list');
       // $canti = Votes::where('idList', $id)->count();

       $canti = Votes::where('idList', $id)->count();
        $data = array(
            'status'    =>  'success',
            'code'      =>  200,
           // 'votes'   =>  $votes,
            'cantidad' => $canti



        );


        return response()->json($data, $data['code']);
    }
 

    public function getVotes()
    {


       // $votes = Votes::where('idList', $id)->get()->load('list');
       // $canti = Votes::where('idList', $id)->count();

       $canti = Votes::where('idList', $id)->count();
        $data = array(
            'status'    =>  'success',
            'code'      =>  200,
           // 'votes'   =>  $votes,
            'cantidad' => $canti



        );


        return response()->json($data, $data['code']);
    }



    public function Votes(Request $request)
    {
        //Recoger datos de usuario por post

        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array


        //validar datos

        if (!empty($params) && !empty($params_array)) {


            $validate = \Validator::make($params_array, [
                'numVote'     =>  'required',
                'idList'     =>  'required'


            ]);


            if ($validate->fails()) {

                $data = array(
                    'status'    =>  'error',
                    'code'      =>  404,
                    'mesaage'   =>  'El registro no se ha realizado',
                    'errors'    =>  $validate->errors()
                );
            } else {

                //votar
                $vote = new Votes();

                //  $post->user_id = $params->user_id;
                $vote->idList = $params_array['idList'];
                $vote->numVote = $params_array['numVote'];
               




                //guardar 

                $vote->save();

                $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'Registro Exitoso',
                    'vote'      => $vote
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

         /*   $validate = \Validator::make($params_array, [

                'numVote'     =>  'required',


            ]);*/

            // quitar campos que no quiero actualizar

            unset($params_array['id']);
            unset($params_array['idList']);

            unset($params_array['created_at']);


            // actualizar categoria en bbdd

            $vote_update = Votes::where('idList', $id)->update($params_array);



            //devolver array

            $data = array(
                'status'    =>  'success',
                'code'      =>  200,
                'votes'  =>  $vote_update

            );
        } else {

            $data = array(
                'status'    =>  'error',
                'code'      =>  400,
                'message'   =>  'No has realizado voto'

            );
        }
    } else {

        $data = array(
            'status'    =>  'error',
            'code'      =>  400,
            'message'   =>  'No existe la list'

        );
    }


    return response()->json($data, $data['code']);
}

public function getVotesById($id)
    {

       
        $votes = Votes::find($id);
        //$canti = $candidates::count();
    
            $data = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'votes'   =>  $votes
                    
                    

                );
            

        return response()->json($data, $data['code']);
    }
    
    
}
