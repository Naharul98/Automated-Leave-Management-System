<?php
use \Codeception\Step\Argument\PasswordArgument;
class AddStaffViewCest
{
  public function _before(AcceptanceTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'nahid@nahid.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }
  
    // tests
  public function testStaffAddFormView(AcceptanceTester $I)
  {
    $I->wantTo('Test staff add form view');
    $I->click('Add New Staff');
    $I->see('Name');
    $I->see('E-Mail Address');
    $I->see('Password');
    $I->see('Confirm Password');
    $I->see('Role');
  }

  
}
?>