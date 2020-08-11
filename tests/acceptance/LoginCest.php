<?php
use \Codeception\Step\Argument\PasswordArgument;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
    }

    // tests
    public function staffSuccessfulLogin(AcceptanceTester $I)
    {
      $I->wantTo('successfully login as a normal staff');
      $I->fillField('email', '1@1.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Previous Holiday Requests');
      $I->seeLink('New Request', '/user_area/request_new_holiday/');
      $I->seeLink('View Previous Requests', '/user_area/index');
      $I->see('Holiday entitlement left in current year : 25');
      $I->seeLink('Request New Holiday', '/user_area/request_new_holiday/');
    }

    public function emptyFailLogin(AcceptanceTester $I)
    {
      $I->wantTo('fail login (No details entered)');
      $I->click(['class' => 'btn']);

      $I->see('The email field is required');
      $I->see('The password field is required');
      $I->seeCurrentUrlEquals('/login');
    }

    public function invalidFailLogin(AcceptanceTester $I)
    {
      $I->wantTo('fail login (Incorrect details entered)');
      //Both wrong email and wrong password give same message
      $I->fillField('email', 'invalid@email.com');
      $I->fillField('password', 'wrong_password');
      $I->click(['class' => 'btn']);

      $I->see('do not match');
      $I->seeCurrentUrlEquals('/login');
    }

    public function invalidFailLoginWrongPassword(AcceptanceTester $I)
    {
      $I->wantTo('fail login (Incorrect password entered)');
      //Both wrong email and wrong password give same message
      $I->fillField('email', 'nahid@nahid.com');
      $I->fillField('password', '123457');
      $I->click(['class' => 'btn']);

      $I->see('do not match');
      $I->seeCurrentUrlEquals('/login');
    }

    public function invalidFailLoginWrongEmail(AcceptanceTester $I)
    {
      $I->wantTo('fail login (Incorrect email entered)');
      //Both wrong email and wrong password give same message
      $I->fillField('email', 'nahid@nahid.co');
      $I->fillField('password', '123456');
      $I->click(['class' => 'btn']);

      $I->see('do not match');
      $I->seeCurrentUrlEquals('/login');
    }

    public function adminSuccessfulLogin(AcceptanceTester $I)
    {
      $I->wantTo('successfully login as an admin or manager');
      $I->fillField('email', 'nahid@nahid.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);

      $I->seeCurrentUrlEquals('/staff_area/admin');
      $I->see('Staffs');
      $I->see('name');
      $I->see('role');
      $I->see('john');
      $I->see('1@1.com');

      $I->see('nahid');
      $I->see('manager');
      $I->see('nahid@nahid.com');
      $I->dontSee('Previous Holiday Requests');
    }





}
?>
