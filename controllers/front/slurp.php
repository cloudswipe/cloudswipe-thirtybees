<?php

class CloudSwipePaymentsSlurpModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->setTemplate("module:cloudswipepayments/views/templates/front/slurp.tpl");
    }
}
