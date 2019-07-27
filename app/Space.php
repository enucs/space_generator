<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
}
