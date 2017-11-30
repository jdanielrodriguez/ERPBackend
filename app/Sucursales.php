<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursales extends Model
{
    use SoftDeletes;
    protected $table = 'sucursales';
}
