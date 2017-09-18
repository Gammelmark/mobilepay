<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-09-2017
 * Time: 11:43
 */

namespace Luxplus\MobilePay\Exceptions;

class CurlException extends \Exception {
    public function __construct($message, $code = 0) {
        $this->message .= "CURL Exception: ". $message."\r\n";
        parent::__construct($this->message, $code);
    }

}