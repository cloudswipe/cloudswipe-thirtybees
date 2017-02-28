<?php

class CloudSwipePaymentsInvoiceModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $psCart = $this->context->cart;
        $psCurrency = Currency::getCurrencyInstance((int)$psCart->id_currency);

        $customer = CloudSwipeCustomer::buildFromPsCart($psCart);
        $lineItems = CloudSwipeLineItems::buildFromPsCart($psCart);
        $lineTotals = CloudSwipeLineTotals::buildFromPsCart($psCart);
        $metaData = CloudSwipeMetaData::buildFromPsCart($psCart);

        $invoice = CloudSwipeInvoice::create([
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
        $psCustomer = new Customer($psCart->id_customer);
        $psConnections = $psCustomer->getLastConnections();

        if (count($psConnections) > 0) {
            $psConnection = $psConnections[0];
            return $psConnection["ipaddress"];
        }
    }
}
