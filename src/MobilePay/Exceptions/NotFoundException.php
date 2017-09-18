<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-09-2017
 * Time: 10:08
 */

namespace Luxplus\MobilePay\Exceptions;


class NotFoundException extends MobilePayException {
    protected $message = "MobilePay Exception: 404 - Not Found. No response body, the resource (agreement or payment) is not found.";

}