<?php
use \Codeception\Step\Argument\PasswordArgument;
use Codeception\Util\Locator;

class ConstraintAlgorithmTestCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', '1@1.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
    $I->amOnPage('/user_area/index');
    $I->click('New Request');
  }

  public function testBlackFridayConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test black friday constraint working');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-11-23');
    $I->fillField('date_to', '2020-11-25');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-11-23 To 2020-11-25');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('Holiday request date falls under black friday and cyber monday period');
    $I->see('Nearest Available Alternatives');
    $I->dontSee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-11-23','date_to' => '2020-11-25','approval' => '0'));
  }

  public function testHolidayEntitlementExceedConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test holiday entitlement exceed constraint working');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-06-01');
    $I->fillField('date_to', '2020-06-26');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-06-01 To 2020-06-26');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('You exceed holiday entitlement for the year 2020');
    $I->see('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->dontSee('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-06-01','date_to' => '2020-06-26','approval' => '0'));
  }

  public function testShiftLeaderConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test at least 1 shift leader must be working in department constraint working');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-09-02');
    $I->fillField('date_to', '2020-09-07');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-09-02 To 2020-09-07');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('At least 1 shift leader must be working in department');
    $I->dontsee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->See('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-09-02','date_to' => '2020-09-07','approval' => '0'));
  }  

  public function testSixtyPercentStaffMustBeOnDutyAtNormalTimesConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test at least 60% of department must be working at normal times constraint working');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-09-06');
    $I->fillField('date_to', '2020-09-10');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-09-06 To 2020-09-10');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('percentage of working employees in a department cannot be less than 60%');
    $I->dontsee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->See('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-09-06','date_to' => '2020-09-10','approval' => '0'));
  }    

  public function testEighhtyPercentStaffMustBeOnDutyAtChristmasTimeConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test at least 80% of department must be working at christmas time constraint');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-12-16');
    $I->fillField('date_to', '2020-12-22');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-12-16 To 2020-12-22');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('During christmas period, total working employees in department cannot go below 80%');
    $I->dontsee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->See('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-12-16','date_to' => '2020-12-22','approval' => '0'));
  }   


  public function testEighhtyPercentStaffMustBeOnDutyAtEasterTimeConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test at least 80% of department must be working at Easter time constraint');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-04-07');
    $I->fillField('date_to', '2020-04-08');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-04-07 To 2020-04-08');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('During easter period, total working employees in department cannot go below 80%');
    $I->dontsee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->See('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-04-07','date_to' => '2020-04-08','approval' => '0'));
  }   

  public function testFiftyPercentStaffMustBeOnDutyAtSummerTimeConstraint(FunctionalTester $I)
  {
    $I->wantTo('Test at least 50% of department must be working at summer time constraint');
    $I->seeInCurrentUrl('/user_area/request_new_holiday/');
    $I->see('Holiday Request Details');
    $I->see('Date From:');
    $I->see('Date To:');
    $I->see('Reason:');

    $I->fillField('date_from', '2020-07-21');
    $I->fillField('date_to', '2020-07-23');
    $I->fillField('reason', 'test reason');
    $I->click('Request Holiday Booking');

    $I->see('Request Details');
    $I->see('2020-07-21 To 2020-07-23');
    $I->see('john');
    $I->see('Constraint Check');
    $I->see('Holiday Request Was Rejected');
    $I->see('During summer period, total working employees in department cannot go below 50%');
    $I->dontsee('Could not suggest alternative because requested number of days exceeds holiday entitlement left for the year');
    $I->See('Nearest Available Alternatives');
    $I->seeRecord('holiday_requests', array('employee_id' => 15,'date_from' => '2020-07-21','date_to' => '2020-07-23','approval' => '0'));
  }     
}
?>
