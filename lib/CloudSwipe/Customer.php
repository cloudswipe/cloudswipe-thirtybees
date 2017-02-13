<?php

namespace CloudSwipe;

class Customer
{
    public $name, $email, $billingAddress, $shippingAddress;

    public static function buildFromPsCart($psCart)
    {
        $customer = new static();

        $psCustomer = new \Customer($psCart->id_customer);
        $customer->name = new \CloudSwipe\Name($psCustomer);
        $customer->email = $psCustomer->email;
        $customer->billingAddress = \CloudSwipe\Address::buildFromPsAddress(
            new \Address((int)$psCart->id_address_invoice)
        );
        $customer->shippingAddress = \CloudSwipe\Address::buildFromPsAddress(
            new \Address((int)$psCart->id_address_delivery)
        );

        return $customer;
    }

    public function toArray()
    {
        return [
            "name" => $this->name->toString(),
            "email" => $this->email,
            "billing_address" => $this->billingAddress->toArray(),
            "shipping_address" => $this->shippingAddress->toArray()
        ];
    }
}
