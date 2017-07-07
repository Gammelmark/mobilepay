<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 24-04-2017
 * Time: 15:24
 */

namespace Luxplus\MobilePay\Requests\Authentication;

use Luxplus\MobilePay\Requests\Request;

class BasicAuthenticationRequest extends Request {

    private $user_name;
    private $password;

    private function __construct() {
    }

    public static function createInstance($user_name, $password) {
        $instance = new self();
        $instance->user_name = $user_name;
        $instance->password = $password;
        return $instance;

    }

    public function toJSON() {
        return json_encode(
            [
                "user_name" => $this->user_name,
                "password"=>$this->password,
            ]
        );
    }

}