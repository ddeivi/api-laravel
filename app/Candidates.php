<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    //
    protected $table = 'candidates';

  /*  protected $fillable = [
        'NAME_CANDIDATE', 'LASTNAME_CANDIDATE', 'category_id', 'image'
    ];*/


   /* public function candidates()
    {
        return $this->hasMany('App\Candidates');
    }*/

    public function list()
    {
        return $this->belongsTo('App\Lists', 'idList');
    }
  
   
    public function type()
    {
        return $this->belongsTo('App\TypeCandidates', 'idTypeCandidate');
    }

   /* public function lists()
    {
        return $this->hasMany('App\Lists');
    }*/

}

