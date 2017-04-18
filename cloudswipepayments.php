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

class CloudSwipePayments extends PaymentModule
{
    public function __construct()
    {
        $this->name = "cloudswipepayments";
        $this->tab = "payments_gateways";
        $this->version = "1.0.0";
        $this->ps_versions_compliancy = array("min" => "1.7", "max" => _PS_VERSION_);
        $this->author = "CloudSwipe";
        $this->controllers = array("invoice", "receipt", "slurp");
        $this->bootstrap = true;

        parent::__construct();

        $this->module_key = "b070eebc9aa650797615a0a9b5598108";
        $this->displayName = $this->l("CloudSwipe Payments");
        $this->description = $this->l("PCI compliant hosted payments with support for a growing list of payment gateways.");

        require_once(dirname(__FILE__)."/lib/CloudSwipe.php");
        CloudSwipe::setEnvironment("production");
        CloudSwipe::setSecretKey(Configuration::get("CLOUDSWIPE_SECRET_KEY"));
    }

    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook("paymentOptions")) {
            return false;
        }

        return true;
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

        return [$option];
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit("submit".$this->name)) {
            $secretKey = (string) Tools::getValue("CLOUDSWIPE_SECRET_KEY");
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
        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $default_lang = (int) Configuration::get("PS_LANG_DEFAULT");

        // Init Fields form array
        $fields_form = array();
        $fields_form[0]["form"] = array(
            "legend" => array(
                "title" => $this->l("Settings"),
            ),
            "input" => array(
                array(
                    "type" => "text",
                    "label" => $this->l("Secret Key"),
                    "name" => "CLOUDSWIPE_SECRET_KEY",
                    "size" => 20,
                    "required" => true
                )
            ),
            "submit" => array(
                "title" => $this->l("Save"),
                "class" => "btn btn-default pull-right"
            )
        );

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite("AdminModules");
        $helper->currentIndex =
            AdminController::$currentIndex."&configure=".$this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;

        // false -> remove toolbar
        $helper->show_toolbar = true;

        // yes - > Toolbar is always visible on the top of the screen.
        $helper->toolbar_scroll = true;

        $helper->submit_action = "submit".$this->name;
        $helper->toolbar_btn = array(
            "save" =>
            array(
                "desc" => $this->l("Save"),
                "href" => AdminController::$currentIndex."&configure=".
                    $this->name."&save".$this->name.
                "&token=".Tools::getAdminTokenLite("AdminModules"),
                ),
                "back" => array(
                    "href" => AdminController::$currentIndex."&token=".
                        Tools::getAdminTokenLite("AdminModules"),
                    "desc" => $this->l("Back to list")
                )
            );

        // Load current value
        $helper->fields_value["CLOUDSWIPE_SECRET_KEY"] =
            Configuration::get("CLOUDSWIPE_SECRET_KEY");

        return $helper->generateForm($fields_form);
    }
}
