<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-09-2017
 * Time: 10:08
 */

namespace Luxplus\MobilePay\Exceptions;


class PreconditionFailedException extends MobilePayException {
    protected $message = "MobilePay Exception: 412 - Precondition Failed.";
}