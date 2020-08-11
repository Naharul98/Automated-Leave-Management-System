<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\User;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\DB;

class Holiday_Request extends Model
{
    protected $table = 'holiday_requests';
	public $timestamps = false;
	protected $guarded = [];

    public function checkConstraint($date_from, $date_to, $user_id)
    {
        $user = User::find($user_id);
        $violations = [];

        $violations[] = $this->checkShiftLeaderConstraint($date_from, $date_to, $user);
        $violations[] = $this->checkBlackFridayConstraint($date_from, $date_to);
        $violations[] = $this->checkHolidayEntitlementExceedConstraint($date_from, $date_to, $user);
        $violations[] = $this->checkOverlapWithAlreadyRequestedHoliday($date_from, $date_to, $user);
        $violations = $this->checkMinimumPercentageConstraint($date_from, $date_to, $user, $violations);

        return $violations;
    }

    public function checkConstraintForAlternativeSuggestion($date_from, $date_to, $user)
    {
        $violations = [];

        if($this->checkShiftLeaderConstraint($date_from, $date_to, $user) != null)
        {
            return true;
        }
        if($this->checkBlackFridayConstraint($date_from, $date_to) != null)
        {
            return true;
        }
        if($this->checkHolidayEntitlementExceedConstraint($date_from, $date_to, $user) != null)
        {
            return true;
        }
        if($this->checkOverlapWithAlreadyRequestedHoliday($date_from, $date_to, $user) != null)
        {
            return true;
        }

        $violations = $this->checkMinimumPercentageConstraint($date_from, $date_to, $user, $violations);
        if(count(array_filter($violations)) >0)
        {
            return true;
        }
        return false;
    }

    private function checkOverlapWithAlreadyRequestedHoliday($date_from, $date_to, $user)
    {
            $numberOfOverlaps =DB::table('holiday_requests')
            ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
            ->where(function ($query) use($user)
            {
               $query->where('holiday_requests.employee_id', $user->id)
                     ->where('holiday_requests.approval','1');
            })->where(function ($query) use($date_from,$date_to)
            {
               $query->whereBetween('holiday_requests.date_from', [$date_from, $date_to]) 
            ->orWhereBetween('holiday_requests.date_to', [$date_from, $date_to]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_from]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_to]);
            })->get()->count();

            if($numberOfOverlaps >0)
            {
                return "You already have requested a holiday in the date range and it has been approved";
            }

        return null;
    }


    private function checkMinimumPercentageConstraint($date_from, $date_to, $user, $violations)
    {

    	$christmasPeriodStart = date("Y") . '-12-15';
    	$christmasPeriodEnd = date("Y") . '-12-22';

    	$easterPeriodStart = date("Y") . '-04-05';
    	$easterPeriodEnd = date("Y") . '-04-19';

    	$summerPeriodStart = date("Y") . '-07-15';
    	$summerPeriodEnd = date("Y") . '-08-31';


    	$totalEmployeesInDepartment = $this->getTotalNumberOfPeopleInDepartment($user->user_department);

    	$numberOfEmployeesOnHolidayInDepartment = $this->numberOfEmployeesOnHolidayInDepartment($date_from, $date_to,$user->user_department);

    	$percentageOfEmployeeWorking = ((($totalEmployeesInDepartment-$numberOfEmployeesOnHolidayInDepartment) -1)/$totalEmployeesInDepartment) * 100;

    	if($this->checkDateWithInRange($date_from,$date_to, $christmasPeriodStart, $christmasPeriodEnd))
    	{
    		if($percentageOfEmployeeWorking <80)
    		{
    			$violations[] = 'During christmas period, total working employees in department cannot go below 80%';
    		}
    	}

    	else if($this->checkDateWithInRange($date_from,$date_to, $easterPeriodStart, $easterPeriodEnd))
    	{
    		if($percentageOfEmployeeWorking <80)
    		{
    			$violations[] = 'During easter period, total working employees in department cannot go below 80%';
    		}
    	}

    	else if($this->checkDateWithInRange($date_from,$date_to, $summerPeriodStart, $summerPeriodEnd))
    	{
    		if($percentageOfEmployeeWorking <50)
    		{
    			$violations[] = 'During summer period, total working employees in department cannot go below 50%';
    		}
    	}

    	else
    	{
    		if($percentageOfEmployeeWorking <60)
    		{
    			$violations[] = 'percentage of working employees in a department cannot be less than 60%';
    		}
    	}
    	return $violations;
    }

    private function checkDateWithInRange($startdate,$enddate, $start_db, $end_db)
    {
    	$daterange1 = array($startdate, $enddate);
		$daterange2 = array($start_db, $end_db);

		$range_min = new DateTime(min($daterange1));
		$range_max = new DateTime(max($daterange1));

		$start = new DateTime(min($daterange2));
		$end = new DateTime(max($daterange2));

		if ($start >= $range_min && $end <= $range_max) 
		{
			return true;
		} 
		else if($end >= $range_min && $start <= $range_max)
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    private function getTotalNumberOfPeopleInDepartment($departmentID)
    {
    	return User::where('user_department', $departmentID)->count();
    }

    private function numberOfEmployeesOnHolidayInDepartment($date_from, $date_to,$departmentID)
    {
        
            return DB::table('holiday_requests')
            ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
            ->where(function ($query) use($departmentID)
            {
               $query->where('users.user_department', $departmentID)
                     ->where('holiday_requests.approval','1');
            })->where(function ($query) use($date_from,$date_to)
            {
               $query->whereBetween('holiday_requests.date_from', [$date_from, $date_to]) 
            ->orWhereBetween('holiday_requests.date_to', [$date_from, $date_to]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_from]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_to]);
            })->groupby('users.id')->get()->count();
            

    }

	private function checkShiftLeaderConstraint($date_from, $date_to, $user)
    {
    	if($user->role == 'shift_leader')
    	{
    		$numberOfShiftLeadersInDepartment = User::where('user_department', $user->user_department)
    		->where('role', 'shift_leader')->get()->count();

           $numberOfShiftLeadersOnHolidayInRequestedDate = DB::table('holiday_requests')
            ->join('users', 'users.id', '=', 'holiday_requests.employee_id')
            ->where(function ($query) use($user)
            {
               $query->where('users.user_department', $user->user_department)
                     ->where('users.role', 'shift_leader')
                     ->where('holiday_requests.approval','1');
            })->where(function ($query) use($date_from,$date_to)
            {
               $query->whereBetween('holiday_requests.date_from', [$date_from, $date_to]) 
            ->orWhereBetween('holiday_requests.date_to', [$date_from, $date_to]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_from]) 
            ->orWhereRaw('? BETWEEN holiday_requests.date_from and holiday_requests.date_to', [$date_to]);
            })->get()->count();

        	if($numberOfShiftLeadersInDepartment > ($numberOfShiftLeadersOnHolidayInRequestedDate+1) == false)
        	{
        		return "At least 1 shift leader must be working in department";
        	}
    	}
        return null;
    }

    private function checkBlackFridayConstraint($date_from, $date_to)
    {
        $blackFridayPeriodStart = date("Y") . '-11-23';
        $blackFridayPeriodEnd = date("Y") . '-11-30';

        if($this->checkDateWithInRange($date_from,$date_to, $blackFridayPeriodStart,$blackFridayPeriodEnd))
        {
            return "Holiday request date falls under black friday and cyber monday period";
        }
        return null;

    }

    private function checkHolidayEntitlementExceedConstraint($date_from, $date_to, $user)
    {
    	$from = new DateTime($date_from);
    	$to = new DateTime($date_to);
    	$fromYear = (int)$from->format('Y');
    	$toYear = (int)$to->format('Y');

    	$numberOfDaysRequested = (int) abs(round((strtotime($date_from)-strtotime($date_to))/(60*60*24)))+1;

    	$numberOfDaysApprovedInTheYear = DB::select(
      										'select SUM(ABS(DATEDIFF(holiday_requests.date_from,holiday_requests.date_to)) +1) as diff from holiday_requests join users on holiday_requests.employee_id=users.id where approval=1 and holiday_requests.employee_id=? and Year(holiday_requests.date_from) IN (?) and Year(holiday_requests.date_to) IN (?)',[$user->id,$fromYear,$toYear]);


    	if(($numberOfDaysApprovedInTheYear[0]->diff + $numberOfDaysRequested) > $user->holiday_entitlement)
    	{
    		return 'You exceed holiday entitlement for the year ' . $fromYear;
    	}

        return null;
    }

    public function getNumberOfHolidayLeftThisYear($user)
    {
        $currentYear = (int)date("Y");
        $numberOfDaysApprovedInTheYear = DB::select(
                                            'select SUM(ABS(DATEDIFF(holiday_requests.date_from,holiday_requests.date_to)) +1) as diff from holiday_requests join users on holiday_requests.employee_id=users.id where approval=1 and holiday_requests.employee_id=? and Year(holiday_requests.date_from) IN (?) and Year(holiday_requests.date_to) IN (?)',[$user->id,$currentYear,$currentYear]);
        return ($user->holiday_entitlement - $numberOfDaysApprovedInTheYear[0]->diff);
    }
}
