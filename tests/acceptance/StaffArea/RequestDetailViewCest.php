<?php

use \Codeception\Step\Argument\PasswordArgument;

class RequestDetailViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1@1.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }

    public function testRequestDetailPage(AcceptanceTester $I){
      $I->wantTo('see if staff can see details of previous holiday request');
      $I->see('Previous Holiday Requests');
      $I->see('Holiday entitlement left in current year');
      $I->seeLink('Request New Holiday', '/user_area/request_new_holiday/');
      $I->see('2020-11-26 to 2020-11-27');
      $I->see('Rejected');
      $I->amOnPage('/user_area/view_request/111');
      $I->see('Request Details');
      $I->see('2020-11-26 To 2020-11-27');
      $I->see('john');
      $I->see('Constraint Check');
      $I->see('Holiday Request Was Rejected');
      $I->see('Holiday request date falls under black friday period');

    }
    

}
?>
