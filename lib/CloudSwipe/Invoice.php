<?php

class CloudSwipeInvoice extends CloudSwipeResource
{
    public function __construct()
    {
        parent::__construct("invoices");
    }

    public static function create($attributes=[])
    {
        $invoice = new self();
        $invoice->attributes = $attributes;
        $http = new CloudSwipeHttp();
        $response = $http->post($invoice);
        $json = json_decode($response->getBody(), true);

        return self::load($json);
    } 

    public static function find($id)
    {
        $invoice = new self();
        $invoice->id = $id;
        $http = new CloudSwipeHttp();
        $response = $http->get($invoice);
        $json = json_decode($response->getBody(), true);

        return self::load($json);
    }

    public static function load($json)
    {
        $invoice = new self();
        $invoice->id = $json["data"]["id"];
        $invoice->type = $json["data"]["type"];
        $invoice->attributes = $json["data"]["attributes"];
        $invoice->links = $json["links"];
        return $invoice;
    }
}
