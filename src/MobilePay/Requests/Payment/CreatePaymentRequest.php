<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 13:36
 */

namespace Luxplus\MobilePay\Requests\Payment;

use Carbon\Carbon;
use Luxplus\MobilePay\Requests\Request;

class CreatePaymentRequest extends Request {

    private $agreement_id;
    private $amount;
    /**
     * @var Carbon $due_date
     */
    private $due_date;
    /**
     * @var Carbon $next_payment_date
     */
    private $next_payment_date;
    private $external_id;
    private $description;

    private function __construct() {
    }

    public static function createInstance(string $agreement_id, $amount, Carbon $due_date, Carbon $next_payment_date, string $external_id, string $description) {

        $instance = new self();
        $instance->agreement_id = $agreement_id;
        $instance->amount = $amount;
        $instance->due_date = $due_date;
        $instance->next_payment_date = $next_payment_date;
        $instance->external_id = $external_id;
        $instance->description = $description;
        return $instance;
    }

    public function jsonSerialize() {
        return [
            "agreement_id" => $this->agreement_id,
            "amount" => $this->amount,
            "due_date" => $this->due_date->toDateString(),
            "next_payment_date" => $this->next_payment_date->toDateString(),
            "external_id" => $this->external_id,
            "description" => $this->description
        ];
    }


}
