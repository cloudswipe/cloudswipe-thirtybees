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

class CloudSwipePaymentsReceiptModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (!Tools::getValue("invoice_id")) {
            PrestaShopLogger::addLog(
                "Missing invoice id",
                3,
                null,
                null,
                null,
                true
            );
            die("Missing invoice id");
        }

        try {
            $invoice =
                CloudSwipeInvoice::find(Tools::getValue("invoice_id"));

            if ($invoice->attributes["metadata"]["order_id"]) {
                die("A PrestaShop order has already been created for this invoice.");
            }

            $this->module->validateOrder(
                (int)$this->context->cart->id,
                (int)Configuration::get("PS_OS_PAYMENT"),
                $invoice->attributes["total"] / 100,
                "Credit Card",
                null,
                [],
                null,
                false,
                $this->context->customer->secure_key
            );

            $order_id = Order::getOrderByCartId($this->context->cart->id);
            if ($order_id) {
                $invoice->update([
                    "metadata" => [
                        "cart_id" => $this->context->cart->id,
                        "order_id" => (int)$order_id
                    ]
                ]);
            }

            Tools::redirect(
                $this->context->link->getPagelink(
                    "order-confirmation.php",
                    null,
                    null,
                    [
                        "id_cart" => (int)$this->context->cart->id,
                        "id_module" => (int)$this->module->id,
                        "id_order" => (int)$this->module->currentOrder,
                        "key" => $this->context->customer->secure_key
                    ]
                )
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                PrestaShopLogger::addLog(
                    $e->getMessage(),
                    3,
                    $e->getResponse()->getStatusCode(),
                    null,
                    null,
                    true
                );
                if ($e->getResponse()->getStatusCode() == 404) {
                    $invoiceId = Tools::getValue("invoice_id");
                    die("Invoice {$invoiceId} not found");
                }
            } else {
                PrestaShopLogger::addLog(
                    $e->getMessage(),
                    3,
                    null,
                    null,
                    null,
                    true
                );
            }

            die($e->getMessage());
        }
    }
}
