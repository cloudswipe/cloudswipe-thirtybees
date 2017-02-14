<?php

include(dirname(__FILE__)."/../../lib/CloudSwipe/CloudSwipe.php");

class CloudSwipeReceiptModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (!isset($_GET["invoice_id"])) {
            PrestaShopLogger::addLog(
                "Missing invoice id", 3, null, null, null, true);
            die("Missing invoice id");
        }

        \CloudSwipe\CloudSwipe::setEnvironment("development");
        \CloudSwipe\CloudSwipe::setSecretKey(
            Configuration::get("CLOUDSWIPE_SECRET_KEY")
        );

        try {
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
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                PrestaShopLogger::addLog(
                    $e->getMessage(), 3, $e->getResponse()->getStatusCode(),
                    null, null, true);
                if ($e->getResponse()->getStatusCode() == 404) {
                    die("Invoice {$_GET["invoice_id"]} not found");
                }
            } else {
                PrestaShopLogger::addLog(
                    $e->getMessage(), 3, null, null, null, true);
            }

            die($e->getMessage());
        }
    }
}
