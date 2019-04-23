<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    protected $table = 'vehiculos';

    public function clientes()
    {
        return $this->hasOne('App\Clientes', 'id', 'cliente');
    }
}
