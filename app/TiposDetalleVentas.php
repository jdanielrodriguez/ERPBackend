<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDetalleVentas extends Model
{
    use SoftDeletes;
    protected $table = 'tiposdetalleventas';
}
