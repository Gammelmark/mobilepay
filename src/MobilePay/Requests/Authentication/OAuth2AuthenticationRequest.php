<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 24-04-2017
 * Time: 15:24
 */

namespace Luxplus\MobilePay\Requests\Authentication;

use Luxplus\MobilePay\Requests\Request;

class OAuth2AuthenticationRequest extends Request {

    private $client_id;
    private $client_secret;
    private $token_url;
    private $scope;

    private function __construct() {
    }

    public static function createInstance($client_id, $client_secret, $token_url, $scope) {
        $instance = new self();
        $instance->client_id = $client_id;
        $instance->client_secret = $client_secret;
        $instance->token_url = $token_url;
        $instance->scope = $scope;
        return $instance;
    }

    public function jsonSerialize() {
        return
            [
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
                "token_url" => $this->token_url,
                "scope" => $this->scope
            ];

    }
}