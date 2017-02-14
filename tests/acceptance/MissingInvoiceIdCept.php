<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo("verify receipt page failure with missing invoice id");

$I->amOnPage("/module/cloudswipe/receipt");
$I->see("Missing invoice id");
