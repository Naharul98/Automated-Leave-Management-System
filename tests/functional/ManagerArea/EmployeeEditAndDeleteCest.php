<?php
use \Codeception\Step\Argument\PasswordArgument;

class EmployeeEditAndDeleteCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'nahid@nahid.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
    $I->amOnPage('/staff_area/admin');
  }

  public function testSelectNoInAdminDeleteConfirmation(FunctionalTester $I)
  { 
    $I->wantTo('Select no during admin delete confirmation');
    $I->amOnPage('/staff_area/admin/delete/13');
    $I->see('Are you sure you want to delete the following Staff');
    $I->click('No');
    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->seeRecord('users', array('name' => 'nahid', 'email' => 'nahid@nahid.com'));

  }

  public function testDeleteStaff(FunctionalTester $I)
  { 
    $I->wantTo('Delete an employee');
    $I->amOnPage('/staff_area/admin/delete/16');
    $I->see('Are you sure you want to delete the following Staff');
    $I->click('Yes');
    $I->see('Employee has been successfully deleted');
    $I->dontSeeRecord('users', array('name' => 'new staff', 'email' => 'new@new.com'));
  }

  public function testEditAdminBlankNameFormSubmission(FunctionalTester $I)
  {
    $I->wantTo('Edit an employee and submit incomplete with missing name');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', '');
    $I->click('Update');
    $I->canSeeInCurrentUrl('/staff_area/admin/update');
  }

  public function testEditAdminBlankEmailFormSubmission(FunctionalTester $I)
  {
    $I->wantTo('Edit an exployee and submit incomplete form with missing email');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('email', '');
    $I->click('Update');
    $I->canSeeInCurrentUrl('/staff_area/admin/update');
  }

  public function testEditFormSubmissionSuccess(FunctionalTester $I)
  {
    $I->wantTo('Edit an employee (to admin) and submit the form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    $I->see('Role');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('role', 'Manager');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('manager', 'table');

    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com', 'role' => 'manager'));
  }
  
  public function testEditDaysWorkingSubmissionToOne(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 1 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '1');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('1', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '6', 'days_working' => '1'));
  }

  public function testEditDaysWorkingSubmissionToTwo(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 2 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '2');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('2', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '11', 'days_working' => '2'));
  }


  public function testEditDaysWorkingSubmissionToThree(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 3 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '3');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('3', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '17', 'days_working' => '3'));
  }

  public function testEditDaysWorkingSubmissionTofour(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 4 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '4');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('4', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '22', 'days_working' => '4'));
  }  

  public function testEditDaysWorkingSubmissionTofive(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 5 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '5');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('5', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '28', 'days_working' => '5'));
  }    

  public function testEditDaysWorkingSubmissionTosix(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 6 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '6');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('6', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '28', 'days_working' => '6'));
  }  


  public function testEditDaysWorkingSubmissionToseven(FunctionalTester $I)
  {
    $I->wantTo('Edit employee days working to 7 and check holiday entitlement form');
    $I->amOnPage('/staff_area/admin/update/16');
    $I->see('Edit');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('days_per_week', '7');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Employee has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('7', 'table');
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com','holiday_entitlement' => '28', 'days_working' => '7'));
  }  
}
?>
