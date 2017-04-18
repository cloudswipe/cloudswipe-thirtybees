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

class CloudSwipeLineItems
{
    public $headers, $rows;

    public function __construct()
    {
        $this->headers =
            array("Item", "Description", "Unit Price", "Quantity", "Total");
        $this->rows = array();
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
        return array(
            "header" => $this->headers,
            "rows" => $this->rows
        );
    }

    private static function buildLineItemRow($psProduct, $psCurrency)
    {
        $row = array();

        $row[] = $psProduct["name"];

        if ($psProduct["attributes_small"]) {
            $row[] = $psProduct["attributes_small"];
        } else {
            $row[] = "N/A";
        }

        $row[] = $psProduct["attributes_small"];
        $row[] = Tools::displayPrice($psProduct["price"], $psCurrency);
        $row[] = $psProduct["cart_quantity"];
        $row[] = Tools::displayPrice($psProduct["total"], $psCurrency);

        return $row;
    }
}
