<?php
use \Codeception\Step\Argument\PasswordArgument;

class EmployeeUserAddAndDeleteCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'nahid@nahid.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }

  public function testAddAnAdminSuccessfully(FunctionalTester $I)
  {
    $I->wantTo('Add an admin');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test Admin Name');
    $I->fillField('email', 'testemail@testemail.com');
    $I->fillField('password', '777777');
    $I->fillField('password_confirmation', '777777');
    $I->selectOption('role', 'manager');

    $I->click('Register');
    $I->see('Employee Record Updated');
    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Test Admin Name', 'table');
    $I->see('testemail@testemail.com', 'table');
    $I->see('manager', 'table');

    $I->seeRecord('users', array('name' => 'Test Admin Name', 'email' => 'testemail@testemail.com', 'role' => 'manager'));

  }

  public function testAddAnEmployeeSuccessfully(FunctionalTester $I)
  {
    $I->wantTo('Add an Employee');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test employee Name');
    $I->fillField('email', 'testemail@testemail.com');
    $I->fillField('password', '777777');
    $I->fillField('password_confirmation', '777777');
    $I->selectOption('role', 'Stocker');

    $I->click('Register');
    $I->see('Employee Record Updated');
    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Test employee Name', 'table');
    $I->see('testemail@testemail.com', 'table');
    $I->see('stocker', 'table');

    $I->seeRecord('users', array('name' => 'Test employee Name', 'email' => 'testemail@testemail.com', 'role' => 'stocker'));
  }  


  public function testAddTwoAdminWithSameEmail(FunctionalTester $I)
  {
    $I->wantTo('Add two manager with same email');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test Admin Name');
    $I->fillField('email', 'testemail@testemail.com');
    $I->fillField('password', '123456');
    $I->fillField('password_confirmation', '123456');
    $I->click('Register');

    $I->click('Add New Staff');
    $I->fillField('name', 'Test Admin Name 2');
    $I->fillField('email', 'testemail@testemail.com');
    $I->fillField('password', '1234567');
    $I->fillField('password_confirmation', '1234567');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');
    $I->see('The email has already been taken.');
    $I->dontSeeRecord('users', array('name' => 'Test Admin Name 2', 'email' => 'testemail@testemail.com'));
  }


  public function testSubmitIncompleteAdminRegisterForm(FunctionalTester $I)
  {
    $I->wantTo('Submit incomplete admin register form');
    $I->click('Add New Staff');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

    $I->fillField('name', 'Test Admin Name');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

    $I->fillField('email', 'testadmin@testadmin.com');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

    $I->fillField('password', '123456');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');
    $I->fillField('password', '');
    $I->fillField('password_confirmation', '123456');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

  }

  public function testSubmitWithPasswordConfirmationNotMatching(FunctionalTester $I)
  {
    $I->wantTo('Submit form with password and password confirmation fields not matching');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test Admin Name');
    $I->fillField('email', 'testadmin@testadmin.com');
    $I->fillField('password', '123456');
    $I->fillField('password_confirmation', '123451');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');
    $I->see('The password confirmation does not match');

  }

  public function testSubmitFormWithInvalidEmailInput(FunctionalTester $I)
  {
    $I->wantTo('Submit form with invalid email form');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test Admin Name');
    $I->fillField('email', 'invalidemail');
    $I->fillField('password', '123456');
    $I->fillField('password_confirmation', '123456');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

    $I->fillField('email', 'invalidemail@.com');
    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');

  }

  public function testSubmitFormWithPasswordLessThanSixCharacters(FunctionalTester $I)
  {
    $I->wantTo('Submit form with password less than 6 characters');
    $I->click('Add New Staff');

    $I->fillField('name', 'Test Admin Name');
    $I->fillField('email', 'testemail@testemail.com');
    $I->fillField('password', '12345');
    $I->fillField('password_confirmation', '12345');

    $I->click('Register');
    $I->canSeeInCurrentUrl('/register');
    $I->see('The password must be at least 6 characters.');
  }

}
?>
