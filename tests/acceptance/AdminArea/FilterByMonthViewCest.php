<?php

use \Codeception\Step\Argument\PasswordArgument;

class FilterByMonthViewCest
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
      $I->amOnPage('/staff_area/admin/filter_by_month');
      $I->wantTo('Employees on Holiday');
      $I->see('Name');
      $I->see('Role');
      $I->see('Department');
      $I->see('Email');
      $I->see('Number of days working');
    }
}
?>
