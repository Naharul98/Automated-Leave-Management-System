

<?php

use \Codeception\Step\Argument\PasswordArgument;

class PreviousHolidayRequestViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1@1.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }


    public function testPreviousHolidayRequestPage(AcceptanceTester $I)
    {
        $I->amOnPage('/user_area/index');
        $I->wantTo('see if user can see previous holiday request');

        $I->see('Previous Holiday Requests');
        $I->see('Holiday entitlement left in current year');
        $I->seeLink('Request New Holiday', '/user_area/request_new_holiday/');
        $I->see('2020-11-26 to 2020-11-27');
        $I->see('Rejected');

    }

}
?>
