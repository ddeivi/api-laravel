<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCandidates extends Model
{
    //
    protected $table = 'typeCandidates';

    public function typeCandidates(){
        return $this->hasMany('App\TypeCandidates');
    }

  


}
