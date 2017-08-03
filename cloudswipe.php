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

if (!defined("_PS_VERSION_")) {
    exit;
}

class CloudSwipe extends PaymentModule
{
    public function __construct()
    {
        $this->name = "cloudswipe";
        $this->tab = "payments_gateways";
        $this->version = "1.0.2";
        $this->ps_versions_compliancy = array("min" => "1.6", "max" => _PS_VERSION_);
        $this->author = "CloudSwipe";
        $this->controllers = array("invoice", "receipt", "slurp");
        $this->bootstrap = true;

        parent::__construct();

        $this->module_key = "b070eebc9aa650797615a0a9b5598108";
        $this->displayName = $this->l("CloudSwipe");
        $this->description = $this->l("Secure hosted payments for your online store");

        require_once(dirname(__FILE__)."/lib/CloudSwipe/Boot.php");
        CloudSwipeEnvironment::set("production");
        CloudSwipeSecretKey::set(Configuration::get("CLOUDSWIPE_SECRET_KEY"));
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        $this->registerHook("paymentOptions");
        $this->registerHook("displayPayment");
        $this->registerHook("paymentReturn");

        return true;
    }

    public function hookDisplayPayment($params)
    {
        if (!$this->active) {
            return;
        }

        $link = $this->context->link->getModuleLink(
            $this->name,
            "invoice",
            array(),
            true
        );

        $this->context->smarty->assign(array(
            'cloudswipe_payment_page' => $link,
        ));

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        $link = $this->context->link->getModuleLink(
            $this->name,
            "invoice",
            array(),
            true
        );

        $option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l("Pay by Credit Card"))
               ->setAction($link);

        return array($option);
    }

    /**
     * This hook is used to display the order confirmation page.
     *
     * @param array $params Hook parameters
     *
     * @return string Hook HTML
     */
    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return '';
        }

        /** @var Order $order */
        $order = $params['objOrder'];

        $currency = new Currency($order->id_currency);

        if (isset($order->reference) && $order->reference) {
            $totalToPay = (float) $order->getTotalPaid($currency);
            $reference = $order->reference;
        } else {
            $totalToPay = $order->total_paid_tax_incl;
            $reference = $this->l('Unknown');
        }

        if ($order->getCurrentOrderState()->id != Configuration::get('PS_OS_ERROR')) {
            $this->context->smarty->assign('status', 'ok');
        }

        $this->context->smarty->assign(
            [
                'id_order'  => $order->id,
                'reference' => $reference,
                'params'    => $params,
                'total'     => Tools::displayPrice($totalToPay, $currency, false),
            ]
        );

        return $this->display(__FILE__, 'views/templates/front/confirmation.tpl');
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit("submit_cloudswipe")) {
            $secretKey = (string) Tools::getValue("cloudswipe_secret_key");
            if (!$secretKey
                || empty($secretKey)
                || !Validate::isGenericName($secretKey)) {
                $output .= $this->displayError($this->l("Invalid Secret Key"));
            } else {
                Configuration::updateValue("CLOUDSWIPE_SECRET_KEY", $secretKey);
                $output .= $this->displayConfirmation(
                    $this->l("Settings updated")
                );
            }
        }

        $this->smarty->assign("cloudswipe_secret_key", Configuration::get("CLOUDSWIPE_SECRET_KEY"));

        return $this->display(__FILE__, "views/templates/hook/settings.tpl");
    }
}
