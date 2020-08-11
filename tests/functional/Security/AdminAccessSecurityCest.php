<?php


class AdminAccessSecurityCest
{

  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', '1@1.com');
    $I->fillField('password', '123456');
    $I->click(['class' => 'btn']);
  }

  public function testStaffCannotAccessManagerAdminArea(FunctionalTester $I)
  {
    $I->wantTo('Test that a normal staff cannot access manager side of the website');
    $I->amOnPage('/staff_area/admin');
    $I->see('403');
  }

}
?>
