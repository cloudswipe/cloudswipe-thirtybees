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
*/

class CloudSwipeLineItems
{
    public $headers, $rows;

    public function __construct()
    {
        $this->headers =
            ["Item", "Description", "Unit Price", "Quantity", "Total"];
        $this->rows = [];
    }

    public static function buildFromPsCart($psCart)
    {
        $lineItems = new self();

        $psProducts = $psCart->getProducts();
        $psCurrency = Currency::getCurrencyInstance((int)$psCart->id_currency);

        foreach ($psProducts as $psProduct) {
            $lineItems->rows[] = self::buildLineItemRow($psProduct, $psCurrency);
        }

        return $lineItems;
    }

    public function toArray()
    {
        return [
            "header" => $this->headers,
            "rows" => $this->rows
        ];
    }

    private static function buildLineItemRow($psProduct, $psCurrency)
    {
        return [
            $psProduct["name"],
            $psProduct["attributes_small"],
            Tools::displayPrice($psProduct["price"], $psCurrency),
            $psProduct["cart_quantity"],
            Tools::displayPrice($psProduct["total"], $psCurrency)
        ];
    }
}
