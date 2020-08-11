<?php

use \Codeception\Step\Argument\PasswordArgument;

class RequestNewHolidayViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1@1.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }

   public function testCreateNewHolidayRequestView(AcceptanceTester $I)
   {
       $I->click('New Request');
       $I->wantTo('see if request new holiday page works properly');
       $I->seeInCurrentUrl('/user_area/request_new_holiday/');
      
       $I->see('Holiday Request Details');
       $I->see('Date From:');
       $I->see('Date To:');
       $I->see('Reason:');
       $I->click('Request Holiday Booking', ['class' => 'btn']);
       $I->seeInCurrentUrl('/user_area/request_new_holiday/');

   }

}
?>
