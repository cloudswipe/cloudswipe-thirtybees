<?php

namespace CloudSwipe;

class Invoice extends \CloudSwipe\Resource
{
    public function __construct()
    {
        parent::__construct("invoices");
    }
}
