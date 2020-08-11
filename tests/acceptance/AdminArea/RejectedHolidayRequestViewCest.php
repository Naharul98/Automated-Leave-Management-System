<?php

use \Codeception\Step\Argument\PasswordArgument;

class RejectedHolidayRequestViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'nahid@nahid.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);
    }

     public function _after(AcceptanceTester $I)
     {
        $I->click('Logout');
    }

    // tests
    public function rejectedHolidayRequestPageTest(AcceptanceTester $I)
    {
      $I->amOnPage('/staff_area/admin/rejected_requests');
      $I->wantTo('See Requests rejected by system From Manager Side');
      $I->see('Name');
      $I->see('Role');
      $I->see('Department');
      $I->see('Request From');
      $I->see('Request To');
      $I->see('john');
      $I->see('shift_leader');
      $I->see('2020-11-26');
      $I->see('2020-11-27');
    }
}
?>
