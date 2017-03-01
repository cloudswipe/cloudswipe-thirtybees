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
* @author Joey Beninghove
* @copyright 2017 CloudSwipe
* @license https://opensource.org/licenses/MIT MIT
*/

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
