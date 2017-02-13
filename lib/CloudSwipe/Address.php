<?php

namespace CloudSwipe;

class Address
{
    public $name, $company, $line1, $line2,
        $city, $state, $zip, $country, $phone;

    public static function buildFromPsAddress($psAddress)
    {
        $address = new static();

        $psState = new \State((int)$psAddress->id_state);
        $psCountry = new \Country((int)$psAddress->id_country);

        $address->name = new \CloudSwipe\Name($psAddress);
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
