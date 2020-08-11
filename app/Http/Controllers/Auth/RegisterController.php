<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Session;
use App\Verification;
use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\AdminSession;
use App\Rules\NewAdminRegistrationSessionInCharge;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user_area/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('register');
    }

    /**
     * Check privilege of the user registering, and depending on that, redirects them to 
     * specific page depending on that 
     *
     * @return void
     */
    public function register(Request $request)
    {
      $this->validator($request->all())->validate();

      event(new Registered($user = $this->create($request->all())));
      if(Auth::check() == false)
      {
        $this->guard()->login($user);
        return $this->registered($request, $user)?: redirect($this->redirectPath());
      }
      else
      {
        return redirect('/staff_area/admin')->with('success','Employee Record Updated');
      }

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      if(Auth::check() == false)
      {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
      }
      else
      {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:255' , new NewAdminRegistrationSessionInCharge($data)],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
      }

    }

    /**
     * Create a new user instance after a valid registration.
     * if user registering is an admin, it creates an admin user
     * and finally, it returns the newly created User.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      if(Auth::check() == false)
      {
        abort(404, "Access denied");
      }
      if(Auth::user()->role === "manager")
      {

        if($data['role'] == 'manager')
        {
          $user =  User::create(['name' => $data['name'],'email' => $data['email'],'password' => Hash::make($data['password']), 'role' => $data['role'],]);
          return $user;
        }
        else
        {
          $entitlement = 0;
          if($data['days_per_week'] >=5)
          {
            $entitlement = 28;
          }
          else
          {
            $entitlement =  (int) round($data['days_per_week'] * 5.6, 0);
          }
          $user =  User::create(['name' => $data['name'],'email' => $data['email'],'password' => Hash::make($data['password']),'user_department' => $data['department_choice'],'has_reset_password' => 0, 'days_working' => $data['days_per_week'], 'holiday_entitlement' => $entitlement, 'role' => $data['role'],]);
          return $user;
        }

      }
    }

    /**
     * returns the view for the registration form
     * 
     * @return view
     */
    public function showRegistrationForm()
    {
      $title = 'Register';
      if(Auth::check() == false)
      {
        abort(404, "Access denied");
      }
      $departments = Department::all();
      return view('auth.register')->with('departments',$departments);
    }



}
