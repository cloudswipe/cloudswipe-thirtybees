<?php

include(dirname(__FILE__)."/../../lib/CloudSwipe/CloudSwipe.php");

class CloudSwipeInvoiceModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        \CloudSwipe\CloudSwipe::setEnvironment("production");
        \CloudSwipe\CloudSwipe::setSecretKey(
            Configuration::get("CLOUDSWIPE_SECRET_KEY")
        );

        $psCart = $this->context->cart;
        $psCurrency = Currency::getCurrencyInstance((int)$psCart->id_currency);

        $customer = \CloudSwipe\Customer::buildFromPsCart($psCart);
        $lineItems = \CloudSwipe\LineItems::buildFromPsCart($psCart);
        $lineTotals = \CloudSwipe\LineTotals::buildFromPsCart($psCart);
        $metaData = \CloudSwipe\MetaData::buildFromPsCart($psCart);

        $invoice = \CloudSwipe\Invoice::create([
            "total" => $psCart->getOrderTotal() * 100,
            "currency" => $psCurrency->iso_code,
            "ip_address" => $this->getIpAddress($psCart),
            "return_url" => $this->context->link->getModuleLink(
                $this->module->name, "receipt"
            ),
            "customer" => $customer->toArray(),
            "line_items" => $lineItems->toArray(),
            "line_totals" => $lineTotals->toArray(),
            "metadata" => $metaData->toArray()
        ]);

        Tools::redirect($invoice->links["pay"]);
    }

    private function getIpAddress($psCart)
    {
        $psCustomer = new \Customer($psCart->id_customer);
        $psConnections = $psCustomer->getLastConnections();

        if (count($psConnections) > 0) {
            $psConnection = $psConnections[0];
            return $psConnection["ipaddress"];
        }
    }
}
