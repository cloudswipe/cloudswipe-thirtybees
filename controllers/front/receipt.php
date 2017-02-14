<?php

include(dirname(__FILE__)."/../../lib/CloudSwipe/CloudSwipe.php");

class CloudSwipeReceiptModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (!isset($_GET["invoice_id"])) {
            # TODO: show some kind of error page or redirect
            return;
        }

        \CloudSwipe\CloudSwipe::setEnvironment("development");
        \CloudSwipe\CloudSwipe::setSecretKey(
            Configuration::get("CLOUDSWIPE_SECRET_KEY")
        );

        $invoice = \CloudSwipe\Invoice::getOne($_GET["invoice_id"]);

        $this->module->validateOrder(
            (int)$this->context->cart->id,
            (int)Configuration::get("PS_OS_PAYMENT"),
            $invoice->attributes["total"] / 100,
            "Credit Card",
            "some message",
            [],
            null,
            false,
            $this->context->customer->secure_key
        );

        Tools::redirect(
            $this->context->link->getPagelink("order-confirmation.php",
            null, null,
            [
                "id_cart" => (int)$this->context->cart->id,
                "id_module" => (int)$this->module->id,
                "id_order" => (int)$this->module->currentOrder,
                "key" => $this->context->customer->secure_key
            ]
        ));
    }
}
