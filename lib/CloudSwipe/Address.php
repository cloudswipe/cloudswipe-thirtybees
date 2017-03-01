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

class CloudSwipeAddress
{
    public $name, $company, $line1, $line2,
        $city, $state, $zip, $country, $phone;

    public static function buildFromPsAddress($psAddress)
    {
        $address = new self();

        $psState = new State((int)$psAddress->id_state);
        $psCountry = new Country((int)$psAddress->id_country);

        $address->name = new CloudSwipeName($psAddress);
        $address->company = $psAddress->company;
        $address->line1 = $psAddress->address1;
        $address->line2 = $psAddress->address2;
        $address->city = $psAddress->city;
        $address->state = $psState->iso_code;
        $address->country = $psCountry->iso_code;
        $address->zip = $psAddress->postcode;
        $address->phone = $psAddress->phone;

        return $address;
    }

    public function toArray()
    {
        return [
            "name" => $this->name->toString(),
            "company" => $this->company,
            "line1" => $this->line1,
            "line2" => $this->line2,
            "city" => $this->city,
            "state" => $this->state,
            "zip" => $this->zip,
            "country" => $this->country,
            "phone" => $this->phone
        ];
    }
}
