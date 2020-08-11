<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    //
    protected $table = 'violations';
	public $timestamps = false;
	protected $guarded = [];
}
