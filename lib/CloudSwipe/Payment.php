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

class CloudSwipePayment extends CloudSwipeResource
{
    public $creditCard;

    public function __construct()
    {
        parent::__construct("payments");
    }

    public static function load($json)
    {
        $payment = new self();
        $payment->id = $json["id"];
        $payment->attributes = $json["attributes"];
        $payment->creditCard = self::loadCreditCard($json);

        return $payment;
    }

    private static function loadCreditCard($json)
    {
        if (!$json["included"]) {
            return;
        }

        $credit_card_json = array_filter($json["included"], function($included) {
            if ($included["type"] == "credit_cards") {
                return $included;
            }
        });

        if ($credit_card_json) {
            return CloudSwipeCreditCard::load(array_values($credit_card_json)[0]);
        }
    }
}
