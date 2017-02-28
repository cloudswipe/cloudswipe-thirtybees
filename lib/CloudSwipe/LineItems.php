<?php

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
