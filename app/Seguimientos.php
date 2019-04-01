<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguimientos extends Model
{
    use SoftDeletes;
    protected $table = 'seguimientos';

    public function clientes()
    {
        return $this->hasOne('App\Clientes', 'id', 'cliente');
    }
}
