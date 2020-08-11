<?php
class HomeViewCest {

    public function testHomePage(AcceptanceTester $I){
        $I->amOnPage('/');
        $I->wantTo('see if home page contains neccessary instructions');

        $I->see('Holiday Reservation');
        $I->see('Step 1: Login');
        $I->see('Step 2: Reserve holiday');
        $I->see('Step 3: Recieve confirmation');
    }


}

?>
