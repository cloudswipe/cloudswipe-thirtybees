<?php

use GuzzleHttp\Client;

class CloudSwipeValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $cart = $this->context->cart;
        $secretKey = 'sk_store_68b8bfedbea80675fcf1374e';
        $apiUrl = 'http://api.cloudswipe.dev/v1/invoices';

        $currency = Currency::getCurrencyInstance((int)$cart->id_currency);

        $client = new Client();
        $response = $client->post($apiUrl, [
            'auth' => [$secretKey, ''],
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => [
                'data' => [
                    'type' => 'invoice',
                    'attributes' => [
                        'total' => $cart->getOrderTotal() * 100,
                        'currency' => $currency->iso_code,
                        'customer' => $this->customerJSON($cart),
                        'line_items' =>
                            $this->lineItemsJSON($cart, $currency),
                        'line_totals' =>
                            $this->lineTotalsJSON($cart, $currency)
                    ]
                ]
            ]
        ]);

        $json = $response->json();
        $id = $json['data']['id'];

        Tools::redirect('http://joey.cloudswipe.dev/pay/' . $id);
    }

    private function fullName($object)
    {
        return implode(" ", [$object->firstname, $object->lastname]);
    }

    private function lineTotalsJSON($cart, $currency)
    {
        $summary = $cart->getSummaryDetails();

        return [
            'rows' => [
                'Discount' => Tools::displayPrice(
                    $summary['total_discounts'], $currency),
                'Shipping' => Tools::displayPrice(
                    $summary['total_shipping'], $currency),
                'Tax' => Tools::displayPrice(
                    $summary['total_tax'], $currency)
            ]
        ];
    }

    private function lineItemsJSON($cart, $currency)
    {
        $products = $cart->getProducts();

        $rows = [];
        foreach ($products as $product) {
            $rows[] = $this->lineItemRowJSON($product, $currency);
        }

        return [
            'header' => ['Item', 'Description', 'Unit Price',
                         'Quantity', 'Total'],
            'rows' => $rows
        ];
    }

    private function lineItemRowJSON($product, $currency)
    {
        return [
            $product['name'],
            $product['attributes_small'],
            Tools::displayPrice($product['price'], $currency),
            $product['cart_quantity'],
            Tools::displayPrice($product['total'], $currency)
        ];
    }

    private function customerJSON($cart)
    {
        $customer = new Customer($cart->id_customer);
        $billingAddress = new Address((int)$cart->id_address_invoice);
        $shippingAddress = new Address((int)$cart->id_address_delivery);

        return [
            'name' => $this->fullName($customer),
            'email' => $customer->email,
            'billing_address' => $this->addressJSON($billingAddress),
            'shipping_address' => $this->addressJSON($shippingAddress)
        ];
    }

    private function addressJSON($address)
    {
        $state = new State((int)$address->id_state);
        $country = new Country((int)$address->id_country);

        return [
            'name' => $this->fullName($address),
            'company' => $address->company,
            'line1' => $address->address1,
            'line2' => $address->address2,
            'city' => $address->city,
            'state' => $state->iso_code,
            'country' => $country->iso_code,
            'zip' => $address->postcode,
            'phone' => $address->phone
        ];
    }
}
