<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correos extends Model
{
    use SoftDeletes;
    protected $table = 'correos';
}
