<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
/*
|-----------------------------------------------------------------------------------
| Delete Account Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling deletion of user accounts
|
*/
class DeleteAccountController extends Controller
{
    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

   /**
    * Passes in necessary data to the delete confirmation view and returns it
    * @param int $user_id
    * @return view
    */
	public function showDeleteAccountConfirmation($user_id)
	{  
		return view('user_area/confirm_delete')->with('user',User::find($user_id));
	}
	
   /**
    * Deletes the user account and returns appropriate view with success message
    * @param int $user_id
    * @return view
    */	
	public function executeDeleteAccount($user_id)
	{
		User::find($user_id)->delete();
		return redirect('/home')->with('success','Your account along with all your existing data has been deleted.');
	}
}
