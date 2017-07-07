<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 13:36
 */

namespace Luxplus\MobilePay\Requests\Agreement;


use Luxplus\MobilePay\Requests\OneOffPayment\CreateOneOffPaymentRequest;
use Luxplus\MobilePay\Requests\Request;
use Carbon\Carbon;

class CreateAgreementRequest extends Request {

    private $amount;
    private $currency;
    private $country_code;
    private $plan;
    private $description;
    /**
     * @var Carbon $next_payment_date
     */
    private $next_payment_date;
    private $frequency;
    private $external_id;
    private $expiration_timeout_minutes;
    private $mobile_phone_number;

    /**
     * @var CreateOneOffPaymentRequest $one_off_payment_request
     */
    private $one_off_payment_request;


    /* links */
    private $link_user_redirect;
    private $link_success_callback;
    private $link_cancel_callback;


    private function __construct() {
    }

    /**
     * Agreement constructor.
     * @param $amount
     * @param $currency
     * @param $countryCode
     * @param $plan
     * @param $description
     * @param $nextPaymentDate
     * @param $frequency
     * @param $externalId
     * @param $expirationTimeoutMinutes
     * @param $mobilePhoneNumber
     * @param $linkUserRedirect
     * @param $linkSuccessCallback
     * @param $linkCancelCallback
     * @param CreateOneOffPaymentRequest $createOneOffPaymentRequest
     * @return $this
     */
    public static function createInstance(
        $amount,
        $currency,
        $countryCode,
        $plan,
        $description,
        $nextPaymentDate,
        $frequency,
        $externalId,
        $expirationTimeoutMinutes,
        $mobilePhoneNumber,
        string $linkUserRedirect,
        string $linkSuccessCallback,
        string $linkCancelCallback,
        CreateOneOffPaymentRequest $createOneOffPaymentRequest = null
    ) {

        $instance = new self();
        $instance->amount = $amount;
        $instance->currency = $currency;
        $instance->country_code = $countryCode;
        $instance->plan = $plan;
        $instance->description = $description;
        $instance->next_payment_date = $nextPaymentDate;
        $instance->frequency = $frequency;
        $instance->external_id = $externalId;
        $instance->expiration_timeout_minutes = $expirationTimeoutMinutes;
        $instance->mobile_phone_number = $mobilePhoneNumber;
        $instance->link_user_redirect = $linkUserRedirect;
        $instance->link_success_callback = $linkSuccessCallback;
        $instance->link_cancel_callback = $linkCancelCallback;
        $instance->one_off_payment_request = $createOneOffPaymentRequest;
        return $instance;
    }

    public static function createSimpleInstance(
        float $amount,
        string $plan,
        string $description,
        Carbon $nextPaymentDate,
        string $externalId,
        string $mobilePhoneNumber,
        string $linkUserRedirect,
        string $linkSuccessCallback,
        string $linkCancelCallback,
        CreateOneOffPaymentRequest $createOneOffPaymentRequest = null
    ) {
        return self::createInstance(
            $amount,
            "DKK",
            "DK",
            $plan,
            $description,
            $nextPaymentDate,
            12,
            $externalId,
            5,
            $mobilePhoneNumber,
            $linkUserRedirect,
            $linkSuccessCallback,
            $linkCancelCallback,
            $createOneOffPaymentRequest);
    }

    public function toJSON() {

        $links = [
            ["rel" => "user-redirect", "href" => $this->link_user_redirect],
            ["rel" => "success-callback", "href" => $this->link_success_callback],
            ["rel" => "cancel-callback", "href" => $this->link_cancel_callback]
        ];

        $tmpArray = [
            "amount" => $this->amount,
            "currency" => $this->currency,
            "country_code" => $this->country_code,
            "plan" => $this->plan,
            "description" => $this->description,
            "next_payment_date" => $this->next_payment_date->toDateString(),
            "frequency" => $this->frequency,
            "external_id" => $this->external_id,
            "expiration_timeout_minutes" => $this->expiration_timeout_minutes,
            "mobile_phone_number" => $this->mobile_phone_number,
            "links" => $links,
        ];

        if($this->one_off_payment_request != null)
            $tmpArray["one_off_payment"] = $this->one_off_payment_request->toArray();

        return json_encode($tmpArray);
    }
}
