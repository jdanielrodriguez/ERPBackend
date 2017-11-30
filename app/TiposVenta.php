<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposVenta extends Model
{
    use SoftDeletes;
    protected $table = 'tiposventa';
}
