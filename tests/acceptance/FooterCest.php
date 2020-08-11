<?php
use \Codeception\Step\Argument\PasswordArgument;
use \Codeception\Util\Locator;

class FooterCest
{
    public function noLoginFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for non logged in users');
        $I->amOnPage('/');
        $I->see('Contacts');
        $I->see('Email');
        $I->seeLink('Shariar.Ahmed@gmail.com', 'mailto:#');
        $I->see('phones');
        $I->see('Links');
        $I->seeLink('Home', '/');

        $I->dontSee('View Approved Requests', 'section-footer');
        $I->dontSee('View Rejected Requests', 'section-footer');
        $I->dontSee('Filter By Month', 'section-footer');
        $I->dontSee('Manage Staff', 'section-footer');
        $I->dontSee('View Previous Requests', 'section-footer');
        $I->dontSee('Request New Holiday', 'section-footer');

        $I->click('Home', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/');
      }

    public function staffFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for logged in staffs');
        $I->amOnPage('/login');
        $I->fillField('email', '1@1.com');
        $I->fillField('password', new PasswordArgument('123456'));
        $I->click(['class' => 'btn']);

        $I->see('Contacts');
        $I->see('Email');
        $I->seeLink('Shariar.Ahmed@gmail.com', 'mailto:#');
        $I->see('phones');
        $I->see('Links');
        $I->seeLink('View Previous Requests', '/user_area/index');
        $I->seeLink('Request New Holiday', '/user_area/request_new_holiday/');

        $I->dontSee('Home', 'section-footer');
        $I->dontSee('View Approved Requests', 'section-footer');
        $I->dontSee('View Rejected Requests', 'section-footer');
        $I->dontSee('Filter By Month', 'section-footer');
        $I->dontSee('Manage Staff', 'section-footer');

        $I->click('View Previous Requests', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/user_area/index');

    }

    public function adminFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for logged in manager or admin');
        $I->amOnPage('/login');
        $I->fillField('email', 'nahid@nahid.com');
        $I->fillField('password', new PasswordArgument('123456'));
        $I->click(['class' => 'btn']);

        $I->see('Contacts');
        $I->see('Email');
        $I->seeLink('Shariar.Ahmed@gmail.com', 'mailto:#');
        $I->see('phones');
        $I->see('Links');
        $I->seeLink('View Approved Requests', '/staff_area/admin/approved_requests');
        $I->seeLink('View Rejected Requests', '/staff_area/admin/rejected_requests');
        $I->seeLink('Filter By Month', '/staff_area/admin/filter_by_month');
        $I->seeLink('Manage Staff', '/staff_area/admin');

        $I->dontSee('View Previous Requests', 'section-footer');
        $I->dontSee('Request New Holiday', 'section-footer');
        $I->dontSee('Home', 'section-footer');

        $I->click('Manage Staff', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/admin');

        $I->click('View Approved Requests', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/admin/approved_requests');
        $I->click('View Rejected Requests', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/admin/rejected_requests');

        $I->click('Filter By Month', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/admin/filter_by_month');

    }

}


?>
