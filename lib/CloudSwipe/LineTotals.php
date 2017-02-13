<?php

namespace CloudSwipe;

class LineTotals
{
    public $rows;

    public function __construct()
    {
        $this->rows = [];
    }

    public static function buildFromPsCart($psCart)
    {
        $lineTotals = new static();

        $psSummary = $psCart->getSummaryDetails();
        $psCurrency = \Currency::getCurrencyInstance((int)$psCart->id_currency);

        $lineTotals->rows[] = [
            "Discount",
            \Tools::displayPrice($psSummary["total_discounts"], $psCurrency)
        ];

        $lineTotals->rows[] = [
            "Shipping",
            \Tools::displayPrice($psSummary["total_shipping"], $psCurrency)
        ];

        $lineTotals->rows[] = [
            "Tax",
            \Tools::displayPrice($psSummary["total_tax"], $psCurrency)
        ];

        return $lineTotals;
    }

    public function toArray()
    {
        return [
            "rows" => $this->rows
        ];
    }
}
