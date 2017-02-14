<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo("verify receipt failure for unknown invoice id");

$I->amOnPage("/module/cloudswipe/receipt?invoice_id=foobar");
$I->see("Invoice foobar not found");
