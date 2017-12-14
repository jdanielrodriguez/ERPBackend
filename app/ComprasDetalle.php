<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprasDetalle extends Model
{
    use SoftDeletes;
    protected $table = 'comprasdetalle';

    public function productos(){
        return $this->hasOne('App\Productos','id','producto');
    }
}
