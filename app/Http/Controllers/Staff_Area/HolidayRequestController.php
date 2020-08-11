<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Holiday_Request;
use App\Violation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use DateTime;
use DatePeriod;
use DateInterval;

class HolidayRequestController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'admin']);
	}

	public function showApprovedRequests()
	{
		$data=[];
		 $data['requestData'] = DB::table('holiday_requests')
        ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
        ->join('department', 'users.user_department', '=', 'department.department_id')
        ->where('holiday_requests.approval',1)->paginate(10);

		return view('staff_area.approved_requests')->with($data);
	}

	public function showRejectedRequests()
	{
		$data=[];
		 $data['requestData'] = DB::table('holiday_requests')
        ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
        ->join('department', 'users.user_department', '=', 'department.department_id')
        ->where('holiday_requests.approval',0)->paginate(10);

		return view('staff_area.rejected_requests')->with($data);
	}

	public function filterByMonth(Request $request)
	{
		return view('staff_area.filter_by_month')->with('tableData',$this->getFilteredData($request))->with('filterFormData',$this->getDataFilterFormPrePopulate($request));
	}

	private function getFilteredData($request)
  	{
  		if($request->isMethod('post'))
    	{ 
    		$lastDayOfMonth = date('t', strtotime($request->input('month')));

    		$date_from = new DateTime($request->input('month') . '-01');
    		$date_to = new DateTime($request->input('month') . '-' . $lastDayOfMonth);

            return DB::table('holiday_requests')
            ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
            ->join('department', 'department.department_id', '=', 'users.user_department')
            ->where(function ($query)
            {
               $query->where('holiday_requests.approval','1');
            })->where(function ($query) use($date_from,$date_to)
            {
               $query->whereBetween('holiday_requests.date_from', [$date_from, $date_to]) 
            ->orWhereBetween('holiday_requests.date_to', [$date_from, $date_to]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_from]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_to]);
            })->groupBy('users.id')->get();
    	}
    	else
    	{
    		$lastDay = date('t',strtotime('today'));
    		$date_from = date('Y-m-' . '01');
    		$date_to = date('Y-m-' . $lastDay);

            return DB::table('holiday_requests')
            ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
            ->join('department', 'department.department_id', '=', 'users.user_department')
            ->where(function ($query)
            {
               $query->where('holiday_requests.approval','1');
            })->where(function ($query) use($date_from,$date_to)
            {
               $query->whereBetween('holiday_requests.date_from', [$date_from, $date_to]) 
            ->orWhereBetween('holiday_requests.date_to', [$date_from, $date_to]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_from]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_to]);
            })->groupBy('users.id')->get();
    	}

    	return $formFilterSelections;
  	}

	private function getDataFilterFormPrePopulate($request)
  	{
  		$dt = (string) date('Y-m');
    	$formFilterSelections = array("month"=>$dt);
    	if($request->isMethod('post'))
    	{ 
      		$formFilterSelections['month'] = $request->input('month');
    	}

    	return $formFilterSelections;
  	}
    
}
