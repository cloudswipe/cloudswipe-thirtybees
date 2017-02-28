<?php

class CloudSwipe
{
    public static $secretKey;
    public static $environment = "production";
    public static $urls = [
        "production" => "https://api.cloudswipe.com/v1/",
        "staging" => "https://api.southchicken.com/v1/",
        "development" => "http://api.cloudswipe.dev/v1/"
    ];

    public static function url()
    {
        return self::$urls[self::$environment];
    }

    public static function setEnvironment($environment)
    {
        self::$environment = $environment;
    }

    public static function setSecretKey($secretKey)
    {
        self::$secretKey = $secretKey;
    }
}

require_once(dirname(__FILE__)."/CloudSwipe/Resource.php");
require_once(dirname(__FILE__)."/CloudSwipe/Address.php");
require_once(dirname(__FILE__)."/CloudSwipe/Customer.php");
require_once(dirname(__FILE__)."/CloudSwipe/Http.php");
require_once(dirname(__FILE__)."/CloudSwipe/Invoice.php");
require_once(dirname(__FILE__)."/CloudSwipe/LineItems.php");
require_once(dirname(__FILE__)."/CloudSwipe/LineTotals.php");
require_once(dirname(__FILE__)."/CloudSwipe/MetaData.php");
require_once(dirname(__FILE__)."/CloudSwipe/Name.php");
require_once(dirname(__FILE__)."/CloudSwipe/Url.php");
