<?php

namespace App\Http\Controllers;

use App\TypeCandidates;
use Illuminate\Http\Request;

class TypeCandidatesController extends Controller
{
    //
    public function getTypes()
    {

        $types = TypeCandidates::all();
 



        return response()->json([

            'status'    =>  'success',
            'code'      =>   200,
            'types'      =>  $types


        ]);
    }
}
