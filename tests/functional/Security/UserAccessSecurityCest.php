<?php

class UserAccessSecurityCest
{
    public function testUserCannotAccessManagerArea(FunctionalTester $I)
    {
        $I->wantTo('Test that an an unauthenticated user does not have access to manager area');
        $I->amOnPage('/staff_area/admin');
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/staff_area/admin');
    }

    public function testUserCannotAccessStaffAreaWithoutLogin(FunctionalTester $I)
    {
        $I->wantTo('Test that an an unauthenticated user does not have access to login area');
        $I->amOnPage('/user_area/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/user_area/index');
    }

}
?>
