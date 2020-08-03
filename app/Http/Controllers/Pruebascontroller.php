<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Candidates;
use App\TypeCandidates;
use App\Votes;
use App\Studies;
use App\User;


class Pruebascontroller extends Controller
{
    //
    public function test()
    {
        $candidates = Candidates::all();
        
        foreach($candidates as $candidate){

           echo "<h1>".$candidate->NAME_CANDIDATE."</h1>";
            echo "<span>{$candidate->type->TYPE_CANDIDATE} - {$candidate->list->LIST_DESCRIPTION}</span>";


        }
        die();
    }


    public function test2()
    {
        $users = User::all();
        
        foreach($users as $user){

            echo "<span>{$user->NAME}</span>";
            echo "<br>";
            echo "<span>{$user->study->semester->NUM_SEMESTER}</span>";



        }
        die();
    }


}
