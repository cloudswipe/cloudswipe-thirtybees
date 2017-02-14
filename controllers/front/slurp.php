<?php

include(dirname(__FILE__)."/../../lib/CloudSwipe/CloudSwipe.php");

class CloudSwipeSlurpModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->setTemplate("module:cloudswipe/views/templates/front/slurp.tpl");
    }
}
