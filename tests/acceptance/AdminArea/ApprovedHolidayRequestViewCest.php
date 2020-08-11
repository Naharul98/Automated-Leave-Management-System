<?php
use \Codeception\Step\Argument\PasswordArgument;
class ApprovedHolidayRequestViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'nahid@nahid.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);
    }
    
    // tests
    public function approvedHolidayRequestPageTest(AcceptanceTester $I)
    {
      $I->amOnPage('/staff_area/admin/approved_requests');
      $I->wantTo('See Requests approved by system From Manager Side');
      $I->see('Name');
      $I->see('Role');
      $I->see('Department');
      $I->see('Request From');
      $I->see('Request To');
      $I->see('Requested by Suggestion');
      $I->see('john');
      $I->see('shift_leader');
      $I->see('2020-12-01');
      $I->see('2020-12-01');
    }
    
}
?>