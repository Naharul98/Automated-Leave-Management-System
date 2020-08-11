<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
     protected $table = 'department';
     protected $primaryKey = 'department_id';
     protected $guarded = [];
     public $timestamps = false;

        /**
    * Returns name of the Model
    * @return Name of Model (String)
    */
    public function getName()
    {
        return 'Department';
    }
}
