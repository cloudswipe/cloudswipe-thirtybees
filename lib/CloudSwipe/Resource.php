<?php

class CloudSwipeResource
{
    public $id;
    public $type;
    public $baseUrl;
    public $attributes = [];
    public $links = [];

    public function __construct($type)
    {
        $this->baseUrl = CloudSwipe::url();
        $this->type = $type;
    }

    public function hasId()
    {
        return !empty($this->id);
    }

    public function toArray()
    {
        $array = [];

        if ($this->id)
            $array["data"]["id"] = $this->id;

        $array["data"]["type"] = $this->type;
        $array["data"]["attributes"] = $this->attributes;

        return $array;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
