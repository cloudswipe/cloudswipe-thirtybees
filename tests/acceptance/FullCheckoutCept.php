<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo("perform a full checkout process");

$I->amGoingTo("navigate to product page");
$I->amOnPage("/tshirts/1-1-faded-short-sleeves-tshirt.html#/1-size-s/13-color-orange");

$I->amGoingTo("add the product to the cart");
$I->click(".add-to-cart");
$I->waitForElementVisible(".cart-content");
$I->see("Product successfully added to your shopping cart");

$I->amGoingTo("go to the checkout page");
$I->click(".btn-primary", ".cart-content");
$I->see("Shopping Cart");
$I->click(".btn-primary", ".checkout");

$I->amGoingTo("fill out the personal information");
$section = "#checkout-personal-information-step";
$I->see("Personal Information");
$I->selectOption("$section input[name=id_gender]", "Mr.");
$I->fillField("$section input[name=firstname]", "Bud");
$I->fillField("$section input[name=lastname]", "Abbott");
$I->fillField("$section input[name=email]", "bud@abbott.com");
$I->click("$section .continue");
$I->makeScreenshot("after-personal");

$I->amGoingTo("fill out the address information");
$section = "#checkout-addresses-step";
$I->see("Addresses");
$I->fillField("$section input[name=firstname]", "Lou");
$I->fillField("$section input[name=lastname]", "Costello");
$I->fillField("$section input[name=company]", "Comedy Club");
$I->fillField("$section input[name=address1]", "123 Anystreet");
$I->fillField("$section input[name=address2]", "Suite B");
$I->fillField("$section input[name=city]", "Anytown");
$I->selectOption("$section select[name=id_state]", "Virginia");
$I->fillField("$section input[name=postcode]", "12345");
$I->selectOption("$section select[name=id_country]", "United States");
$I->fillField("$section input[name=phone]", "111-222-3333");
$I->click("$section .continue");
$I->makeScreenshot("after-addresses");

$I->amGoingTo("select the shipping method");
$section = "#checkout-delivery-step";
$I->see("Shipping Method");
$I->click("$section .continue");
$I->makeScreenshot("after-shipping");

$I->amGoingTo("select the payment method");
$section = "#checkout-payment-step";
$I->see("Payment");
$I->selectOption("$section input[name=payment-option]", ["id" => "payment-option-3"]);
$I->checkOption("$section #conditions-to-approve input[type=checkbox]");
$I->click("$section #payment-confirmation .btn-primary");
$I->makeScreenshot("after-payment-method");

$I->amGoingTo("fill out the payment information on CloudSwipe");
$section = ".cloudswipe";
$I->see("My Store", ".cloudswipe");
$I->fillField("$section input[name='payment[credit_card][name]']", "Bud Abbott");
$I->fillField("$section input[name='payment[credit_card][number]']", "4111111111111111");
$I->fillField("$section input[name='payment[credit_card][expiration]']", "02/20");
$I->fillField("$section input[name='payment[credit_card][cvv]']", "123");
$I->click("$section input[name=commit]");
$I->see("Your Order Is Confirmed");
$I->makeScreenshot("after-payment");
