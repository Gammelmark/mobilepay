<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 13:36
 */

namespace Luxplus\MobilePay\Requests\Refund;

use Luxplus\MobilePay\Requests\Request;

class CreateRefundRequest extends Request {

    private $amount;
    private $statusCallbackUrl;

    private function __construct() {
    }

    public static function createInstance($amount, string $statusCallbackUrl) {

        $instance = new self();
        $instance->amount = $amount;
        $instance->statusCallbackUrl = $statusCallbackUrl;
        return $instance;
    }

    public function toJSON() {

        return json_encode([[
                "amount" => $this->amount,
                "status_callback_url" => $this->statusCallbackUrl
            ]]
        );
    }


}
