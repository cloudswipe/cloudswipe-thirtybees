<?php
/**
* The MIT License (MIT)
* 
* Copyright (c) 2017 CloudSwipe
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @author    Joey Beninghove
* @copyright 2017 CloudSwipe
* @license   https://opensource.org/licenses/MIT MIT
*/

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
                $this->module->name,
                "receipt"
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
