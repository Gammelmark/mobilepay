<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 13:36
 */

namespace Luxplus\MobilePay\Requests\OneOffPayment;

use Carbon\Carbon;
use Luxplus\MobilePay\Requests\Request;

class CreateOneOffPaymentRequest extends Request {

    private $amount;
    private $external_id;
    private $description;

    private function __construct() {
    }

    public static function createInstance($amount, string $external_id, string $description) {

        $instance = new self();
        $instance->amount = $amount;
        $instance->external_id = $external_id;
        $instance->description = $description;
        return $instance;
    }

    public function toJSON() {
        return json_encode(
          [
              "amount"=>$this->amount,
              "external_id" => $this->external_id,
              "description" => $this->description
          ]
        );
    }


}
