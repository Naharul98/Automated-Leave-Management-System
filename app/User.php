<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role','user_department','holiday_entitlement','days_working','has_reset_password',];

    protected $primaryKey = 'id';

    protected $table = 'users';
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * set up relationship between the user and the verification model
     *
     */
    public function verifyUser()
    {
        return $this->hasOne('App\Verification');
    }
    
    public function session(){
        return $this->hasOne('App\Session');
    }
    
    public function getName()
    {
        return 'Employee';
    }
    /**
     * Get collection of user objects who are admins
     *
     * @return collection of User Objects
     */
    public function getUserList()
    {
        return $this->leftjoin('department', 'users.user_department', '=', 'department.department_id')->whereRaw('1 = 1');;
    }

}
