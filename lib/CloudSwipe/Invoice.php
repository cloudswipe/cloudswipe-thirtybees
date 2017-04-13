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

    public function update($attributes=[])
    {
        $http = new CloudSwipeHttp();
        $this->attributes = $attributes;
        $response = $http->patch($this);
        $json = json_decode($response->getBody(), true);

        return CloudSwipeInvoice::load($json);
    }
}
