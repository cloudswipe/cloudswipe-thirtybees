<?php

namespace CloudSwipe;

class CloudSwipe
{
    public static $environment = "production";
    public static $urls = [
        "production" => "https://api.cloudswipe.com/v1/",
        "staging" => "https://api.southchicken.com/v1/",
        "development" => "http://api.cloudswipe.dev/v1/"
    ];

    public static function url()
    {
        return static::$urls[static::$environment];
    }

    public static function setEnvironment($environment)
    {
        static::$environment = $environment;
    }

    public static function setSecretKey($secretKey)
    {
        Resource::auth($secretKey);
    }
}

require_once(dirname(__FILE__)."/JsonApiClient/Url.php");
require_once(dirname(__FILE__)."/JsonApiClient/Http.php");
require_once(dirname(__FILE__)."/JsonApiClient/Resource.php");
require_once(dirname(__FILE__)."/Resource.php");
require_once(dirname(__FILE__)."/Address.php");
require_once(dirname(__FILE__)."/Customer.php");
require_once(dirname(__FILE__)."/Invoice.php");
require_once(dirname(__FILE__)."/LineItems.php");
require_once(dirname(__FILE__)."/LineTotals.php");
require_once(dirname(__FILE__)."/MetaData.php");
require_once(dirname(__FILE__)."/Name.php");
