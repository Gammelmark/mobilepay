<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 24-04-2017
 * Time: 15:24
 */
namespace Luxplus\MobilePay\Requests\Authentication;

use Luxplus\MobilePay\Requests\Request;

class ApiKeyAuthenticationRequest extends Request {

    private $api_key;

    private function __construct() {
    }

    public static function createInstance($api_key) {
        $instance = new self();
        $instance->api_key= $api_key;
        return $instance;

    }

    public function jsonSerialize() {
        return ["api_key"=>$this->api_key];
    }

}