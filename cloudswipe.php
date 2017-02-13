<?php

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined("_PS_VERSION_")) {
    exit;
}

class CloudSwipe extends PaymentModule
{
    public function __construct()
    {
        $this->name = "cloudswipe";
        $this->tab = "payments_gateways";
        $this->version = "1.0.0";
        $this->ps_versions_compliancy = [
            "min" => "1.7",
            "max" => _PS_VERSION_
        ];
        $this->author = "Joey Beninghove";
        $this->controllers = ["createinvoice"];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l("CloudSwipe");
        $this->description = $this->l("Accepts payments through CloudSwipe");
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
            $this->name, "createinvoice", [], true
        );

        $option = new PaymentOption();
        $option->setCallToActionText($this->l("Pay by Credit Card"))
               ->setAction($link);

        return [$option];
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit("submit".$this->name))
        {
            $secretKey = strval(Tools::getValue("CLOUDSWIPE_SECRET_KEY"));
            if (!$secretKey
                || empty($secretKey)
                || !Validate::isGenericName($secretKey))
                $output .= $this->displayError($this->l("Invalid Secret Key"));
            else
            {
                Configuration::updateValue("CLOUDSWIPE_SECRET_KEY", $secretKey);
                $output .= $this->displayConfirmation(
                    $this->l("Settings updated"));
            }
        }
        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get("PS_LANG_DEFAULT");

        // Init Fields form array
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
