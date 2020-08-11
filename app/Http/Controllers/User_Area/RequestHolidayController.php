<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Holiday_Request;
use App\Violation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use DatePeriod;
use DateInterval;

class RequestHolidayController extends Controller
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
		return view('user_area.create_holiday_request');
	}

	//to do
	public function makeRequest(Request $request)
	{
		$data=[];
		$constraintChecker = new Holiday_Request();
		$result = $constraintChecker->checkConstraint($request->input('date_from'), $request->input('date_to'), Auth::user()->id);
		$result = array_filter($result);

		if(empty($result))
		{
			$req = Holiday_Request::create(['employee_id' => Auth::user()->id,'reason' => $request->input('reason'),'approval' => 1, 'date_from' => $request->input('date_from'),'was_requested_by_suggestion' => 0,'date_to' => $request->input('date_to'),]);

			$data['request_data'] = DB::table('holiday_requests')
        							->join('users', 'users.id', '=', 'holiday_requests.employee_id')
        							->where('holiday_requests.request_id',$req->id)->first();
			$data['approval'] = 1;

			return view('user_area.request_result')->with($data);
		}
		else
		{
			$data['approval'] = 0;
			$req = Holiday_Request::create(['employee_id' => Auth::user()->id,'reason' => $request->input('reason'),'approval' => 0,'was_requested_by_suggestion' => 0, 'date_from' => $request->input('date_from'),'date_to' => $request->input('date_to'),]);

			foreach ($result as $errorMessage)
			{
				Violation::create(['request_id' => $req->id,'reason' => $errorMessage,]);
			}

			$data['request_data'] = DB::table('holiday_requests')
        							->join('users', 'users.id', '=', 'holiday_requests.employee_id')
        							->where('holiday_requests.request_id',$req->id)->first();

        	$data['violations'] =  Violation::where('request_id', $req->id)->get();

            $data['alternatives'] = $this->suggestAlternative($request->input('date_from'), $request->input('date_to'));

        	return view('user_area.request_result')->with($data);

		}
	}

    public function requestHolidayFromAlternative(Request $request)
    {
        $data=[];
        $constraintChecker = new Holiday_Request();
        $result = $constraintChecker->checkConstraint($request->input('date_from'), $request->input('date_to'), Auth::user()->id);
        $result = array_filter($result);

        if(empty($result))
        {
            $req = Holiday_Request::create(['employee_id' => Auth::user()->id,'reason' => $request->input('reason'),'approval' => 1, 'date_from' => $request->input('date_from'),'was_requested_by_suggestion' => 1,'date_to' => $request->input('date_to'),]);

            $data['request_data'] = DB::table('holiday_requests')
                                    ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
                                    ->where('holiday_requests.request_id',$req->id)->first();
            $data['approval'] = 1;

            return view('user_area.request_result')->with($data);
        }
        else
        {
            $data['approval'] = 0;
            $req = Holiday_Request::create(['employee_id' => Auth::user()->id,'reason' => $request->input('reason'),'approval' => 0,'was_requested_by_suggestion' => 1, 'date_from' => $request->input('date_from'),'date_to' => $request->input('date_to'),]);

            foreach ($result as $errorMessage)
            {
                Violation::create(['request_id' => $req->id,'reason' => $errorMessage,]);
            }

            $data['request_data'] = DB::table('holiday_requests')
                                    ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
                                    ->where('holiday_requests.request_id',$req->id)->first();

            $data['violations'] =  Violation::where('request_id', $req->id)->get();

            $data['alternatives'] = $this->suggestAlternative($request->input('date_from'), $request->input('date_to'));

            return view('user_area.request_result')->with($data);

        }
    }


	private function suggestAlternative($date_from, $date_to)
	{
		$constraintChecker = new Holiday_Request();
		$numberOfDaysRequested = (int)abs(round((strtotime($date_from)-strtotime($date_to))/(60*60*24)))+1;
		$toReturn = array("lowerSuggestion"=>null, "upperSuggestion"=>null, "error"=>null);

		if($numberOfDaysRequested>$constraintChecker->getNumberOfHolidayLeftThisYear(Auth::user()))
		{
			$toReturn["error"] = "Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year";
			return $toReturn;
		}

		$from = new DateTime($date_from);
    	$to = new DateTime($date_to);

    	$currentDate = (string)date("Y-m-d");
    	$currentDate = new DateTime($currentDate);
    	$lastDateOfYear = (string)(date("Y") . '-12-31');
    	$lastDateOfYear = new DateTime($lastDateOfYear);
    	
    	$lowerBound = (new DateTime($date_from))->modify('-3 months');
    	if($lowerBound <= $currentDate)
    	{
    		$lowerBound = $currentDate;
    	}
    	$upperBound = (new DateTime($date_to))->modify('+3 months');
    	if($upperBound>$lastDateOfYear)
    	{
    		$upperBound = $lastDateOfYear;
    	}
    	
    	$fromLower = (new DateTime($date_from))->modify('-' . $numberOfDaysRequested . ' days');
    	$toLower = (new DateTime($date_to))->modify('-' . $numberOfDaysRequested . ' days');
    	
    	while($fromLower > $lowerBound && $toLower > $lowerBound)
    	{
    		if($constraintChecker->checkConstraintForAlternativeSuggestion($fromLower->format('Y-m-d'),$toLower->format('Y-m-d'),Auth::user()) == false)
    		{
    			$toReturn["lowerSuggestion"] = [$fromLower->format('Y-m-d'), $toLower->format('Y-m-d')];
    			break;
    		}
    		else
    		{
    			$fromLower = $fromLower->modify('-' . $numberOfDaysRequested . ' days');
    			$toLower = $toLower->modify('-' . $numberOfDaysRequested . ' days');
    		}
    	}
    	
        $fromUpper = (new DateTime($date_from))->modify('+' . $numberOfDaysRequested . ' days');
        $toUpper = (new DateTime($date_to))->modify('+' . $numberOfDaysRequested . ' days');

        while($fromUpper < $upperBound && $toUpper < $upperBound)
        {
            if($constraintChecker->checkConstraintForAlternativeSuggestion($fromUpper->format('Y-m-d'),$toUpper->format('Y-m-d'),Auth::user()) == false)
            {
                $toReturn["upperSuggestion"] = [$fromUpper->format('Y-m-d'), $toUpper->format('Y-m-d')];
                break;
            }
            else
            {
                $fromUpper = $fromUpper->modify('+' . $numberOfDaysRequested . ' days');
                $toUpper = $toUpper->modify('+' . $numberOfDaysRequested . ' days');
            }
        }
        return $toReturn;

	}
}
