<?php

namespace CloudSwipe;

class MetaData
{
    public $data;

    public function __construct()
    {
        $this->data = [];
    }

    public static function buildFromPsCart($psCart)
    {
        $metaData = new static();

        $metaData->data["foo"] = "bar";

        return $metaData;
    }

    public function toArray()
    {
        return $this->data;
    }
}
