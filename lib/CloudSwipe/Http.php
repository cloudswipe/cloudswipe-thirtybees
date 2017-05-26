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

class CloudSwipeHttp
{
    public $client;

    public function __construct($client=null)
    {
        if ($client)
            $this->client = $client;
        else
            $this->client = new \GuzzleHttp\Client();
    }

    public function post($resource)
    {
        $options = $this->options("POST", $resource);
        return $this->request("POST", CloudSwipeUrl::create($resource), $options);
    }

    public function patch($resource)
    {
        $options = $this->options("PATCH", $resource);
        return $this->request("PATCH", CloudSwipeUrl::update($resource), $options);
    }

    public function delete($resource)
    {
        $options = $this->options("DELETE", $resource);
        return $this->request("DELETE", CloudSwipeUrl::delete($resource), $options);
    }

    public function get($resource)
    {
        $options = $this->options("GET", $resource);
        if ($resource->hasId())
            return $this->request("GET", CloudSwipeUrl::getOne($resource), $options);
        else
            return $this->request("GET", CloudSwipeUrl::getAll($resource), $options);
    }

    public function request($method, $url, $options=[])
    {
        if (defined('_TB_VERSION_')) {
            $request = $this->client->request($method, $url, $options);

            return $request;
        }

        $request = $this->client->createRequest($method, $url, $options);

        return $this->client->send($request);
    }

    public function options($method, $resource)
    {
        $class = get_class($resource);
        $options = array(
            "auth" => array(CloudSwipe::$secretKey, ""),
            "headers" => array("Accept" => "application/vnd.api+json")
        );

        switch ($method) {
        case "POST":
            $options["headers"]["Content-Type"] = "application/vnd.api+json";
            $options["json"] = $resource->toArray();
        case "PATCH":
            $options["headers"]["Content-Type"] = "application/vnd.api+json";
            $options["json"] = $resource->toArray();
        }

        return $options;
    }
}
