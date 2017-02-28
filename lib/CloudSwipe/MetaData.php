<?php

class CloudSwipeMetaData
{
    public $data;

    public function __construct()
    {
        $this->data = [];
    }

    public static function buildFromPsCart($psCart)
    {
        $metaData = new self();

        $metaData->data["foo"] = "bar";

        return $metaData;
    }

    public function toArray()
    {
        return $this->data;
    }
}
