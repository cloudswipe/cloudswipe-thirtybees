<?php

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined("_PS_VERSION_")) {
    exit;
}

class CloudSwipe extends PaymentModule
{
    public $secretKey = "sk_store_68b8bfedbea80675fcf1374e";

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
}
