<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';

    public function selling(){
    	return $this->hasMany('App\Selling', 'supplier_id');
    }
}
