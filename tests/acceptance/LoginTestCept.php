<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

$I->amOnPage('/login');
$I->fillField('#signinform-username', 'admin');
$I->fillField('#signinform-password', 'admin');
$I->seeCheckboxIsChecked('#signinform-rememberme');
$I->dontSee('help-block');
$I->click('Login', '.btn');

