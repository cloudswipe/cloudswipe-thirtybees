<?php

class CloudSwipeSlurpModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->setTemplate("module:cloudswipe/views/templates/front/slurp.tpl");
    }
}
