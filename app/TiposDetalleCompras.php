<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDetalleCompras extends Model
{
    use SoftDeletes;
    protected $table = 'tiposdetallecompras';
}
