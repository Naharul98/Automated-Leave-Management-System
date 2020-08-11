<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Holiday_Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Violation;
use Session;
use Redirect;
use Illuminate\Support\Facades\Hash;
/*
|-----------------------------------------------------------------------------------
| Dashboard Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling the dashboard area of the user
|
*/
class DashboardController extends Controller
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
    * Passes in necessary data to the dashboard view, and returns the view
    *
    * @return view
    */
	public function index()
	{
		$data=[];
		$user = Auth::user();
		$data['user'] = $user;
        if(($user->has_reset_password == 0))
        {
            return view('user_area.change_password');
        }
        $data['holidays_requested'] = $this->getListOfHolidayRequestedPreviously($user->id);
        $data['number_of_days_left'] = $this->getNumberOfHolidayLeftThisYear($user);
		return view('user_area.index')->with($data);
	}


    private function getNumberOfHolidayLeftThisYear($user)
    {
        $constraintChecker = new Holiday_Request();
        return $constraintChecker->getNumberOfHolidayLeftThisYear($user);
    }

    public function changePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $user = Auth::user();
            $user->password = Hash::make($request->input('password'));
            $user->has_reset_password = 1;
            $user->save();
            return view('home_area.index')->with('success', 'Password has been updated');

        }
        return view('user_area.change_password');
    }

    private function getListOfHolidayRequestedPreviously($user_id)
    {
        return Holiday_Request::where('employee_id', $user_id)->orderBy('requested_at', 'DESC')->get();
    }

    //to do
    public function showRequest($request_id)
    {
        $data=[];
        $requestRecord = DB::table('holiday_requests')
        ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
        ->where('holiday_requests.request_id',$request_id)->first();

        $data['requestData'] = $requestRecord;
        $data['violations'] =  Violation::where('request_id', $request_id)->get();
        return view('user_area.view_request')->with($data);
    }

    public function removeRejectedRequest($request_id)
    {
        Holiday_Request::where('request_id',$request_id)->delete();
        $data=[];
        $user = Auth::user();
        $data['user'] = $user;
        $data['holidays_requested'] = $this->getListOfHolidayRequestedPreviously($user->id);
        $data['number_of_days_left'] = $this->getNumberOfHolidayLeftThisYear($user);
        return view('user_area.index')->with($data);
    }

}
