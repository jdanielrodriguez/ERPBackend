<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citas extends Model
{
    use SoftDeletes;
    protected $table = 'citas';

    public function clientes()
    {
        return $this->hasOne('App\Citas', 'id', 'cliente');
    }
}
