<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 12:03
 */

namespace Luxplus\MobilePay;

use Luxplus\MobilePay\Connection\MobilePayConnectionConfiguration;
use Luxplus\MobilePay\Connection\MobilePayConnectionManager;
use Luxplus\MobilePay\Requests\Agreement\CreateAgreementRequest;
use Luxplus\MobilePay\Requests\Agreement\UpdateAgreementRequest;
use Luxplus\MobilePay\Requests\Authentication\ApiKeyAuthenticationRequest;
use Luxplus\MobilePay\Requests\Authentication\BasicAuthenticationRequest;
use Luxplus\MobilePay\Requests\Authentication\OAuth2AuthenticationRequest;
use Luxplus\MobilePay\Requests\Merchant\UpdateMerchantRequest;
use Luxplus\MobilePay\Requests\OneOffPayment\CreateOneOffPaymentRequest;
use Luxplus\MobilePay\Requests\Payment\CreatePaymentRequest;
use Luxplus\MobilePay\Requests\Refund\CreateRefundRequest;


class MobilePaySubscriptionClient {

    /**
     * @var MobilePayConnectionManager
     */
    private $mobilePayConnectionManager;

    /**
     * MobilePaySubscriptionClient constructor.
     * @param string|null $connectionName can be an empty string
     * @param MobilePayConnectionConfiguration $mobilePayConfiguration
     */
    private function __construct(MobilePayConnectionConfiguration $mobilePayConfiguration, string $connectionName = null) {
        $this->mobilePayConnectionManager = MobilePayConnectionManager::getInstance($mobilePayConfiguration, $connectionName);
    }

    /**
     * @param MobilePayConnectionConfiguration $mobilePayConfiguration
     * @param string|null $connectionName can be an empty string
     * @return MobilePaySubscriptionClient
     */
    public static function createInstance(MobilePayConnectionConfiguration $mobilePayConfiguration, string $connectionName = null) {
        return new self($mobilePayConfiguration, $connectionName);
    }


    /**
     * Summary: Get a list of agreements.
     * Description: Get a list of agreements.
     *
     * @return mixed
     */
    public function getAgreementRequests() {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements');
    }

    /**
     * @param string $agreementRequestId
     * @return mixed
     */
    public function getAgreementRequest(string $agreementRequestId) {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId);
    }

    /**
     * @param CreateAgreementRequest $agreementRequest
     * @return mixed
     */
    public function postAgreementRequest(CreateAgreementRequest $agreementRequest) {
        return $this->mobilePayConnectionManager->post("/recurringpayments-restapi/api/merchants/me/agreements", $agreementRequest);
    }

    /**
     * @param string $agreementRequestId
     * @return mixed
     */
    public function deleteAgreementRequest(string $agreementRequestId) {
        return $this->mobilePayConnectionManager->delete('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId);
    }

    /**
     * @param string $agreementRequestId
     * @param UpdateAgreementRequest $agreementRequest
     * @return mixed
     */
    public function patchAgreementRequest(string $agreementRequestId, UpdateAgreementRequest $agreementRequest) {
        return $this->mobilePayConnectionManager->patch("/recurringpayments-restapi/api/merchants/me/agreements/" . $agreementRequestId, $agreementRequest);
    }


    /**
     * @param string $agreementRequestId
     * @return mixed
     */
    public function getPaymentRequests(string $agreementRequestId) {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests');
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @return mixed
     */
    public function getPaymentRequest(string $agreementRequestId, string $paymentRequestId) {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId);
    }

    /**
     * @param CreatePaymentRequest $paymentRequest
     * @return mixed
     */
    public function postPaymentRequests(CreatePaymentRequest $paymentRequest) {
        return $this->mobilePayConnectionManager->post('/recurringpayments-restapi/api/merchants/me/paymentrequests', $paymentRequest);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @return mixed
     */
    public function deletePaymentRequest(string $agreementRequestId, string $paymentRequestId) {
        return $this->mobilePayConnectionManager->delete('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param CreatePaymentRequest $paymentRequest
     * @return mixed
     */
    public function patchPaymentRequest(string $agreementRequestId, string $paymentRequestId, CreatePaymentRequest $paymentRequest) {
        return $this->mobilePayConnectionManager->patch('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId, $paymentRequest);
    }


    /**
     * @param string $agreementRequestId
     * @return mixed
     */
    public function getOneOffPayments(string $agreementRequestId) {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments');
    }

    /**
     * @param string $agreementRequestId
     * @param string $oneOffPaymentRequestId
     * @return mixed
     */
    public function getOneOffPayment(string $agreementRequestId, string $oneOffPaymentRequestId) {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $oneOffPaymentRequestId);
    }

    /**
     * @param string $agreementRequestId
     * @param CreateOneOffPaymentRequest $oneOffPaymentRequest
     * @return mixed
     */
    public function postOneOffPayment(string $agreementRequestId, CreateOneOffPaymentRequest $oneOffPaymentRequest) {
        return $this->mobilePayConnectionManager->post('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments', $oneOffPaymentRequest);
    }

    /**
     * @param string $agreementRequestId
     * @param string $oneOffPaymentRequestId
     * @return mixed
     */
    public function deleteOneOffPayment(string $agreementRequestId, string $oneOffPaymentRequestId) {
        return $this->mobilePayConnectionManager->delete('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $oneOffPaymentRequestId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @return mixed
     */
    public function captureOneOffPayment(string $agreementRequestId, string $paymentRequestId) {
        return $this->mobilePayConnectionManager->post('/recurringpayments-restapi/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $paymentRequestId . '/capture');
    }


    /**
     * @return mixed
     */
    public function getMerchantConfiguration() {
        return $this->mobilePayConnectionManager->get('/recurringpayments-restapi/api/merchants/me');
    }

    /**
     * @param UpdateMerchantRequest $updateMerchantRequest
     * @return mixed
     */
    public function patchMerchantConfiguration(UpdateMerchantRequest $updateMerchantRequest) {
        return $this->mobilePayConnectionManager->patch('/recurringpayments-restapi/api/merchants/me', $updateMerchantRequest);
    }

    /**
     * @param ApiKeyAuthenticationRequest $apiKeyAuthenticationRequest
     * @return mixed
     */
    public function putAPIKeyAuthentication(ApiKeyAuthenticationRequest $apiKeyAuthenticationRequest) {
        return $this->mobilePayConnectionManager->put('/recurringpayments-restapi/api/merchants/me/auth/apikey', $apiKeyAuthenticationRequest);
    }

    /**
     * @param OAuth2AuthenticationRequest $oAuth2AuthenticationRequest
     * @return mixed
     */
    public function putOAuth2Authentication(OAuth2AuthenticationRequest $oAuth2AuthenticationRequest) {
        return $this->mobilePayConnectionManager->put('/recurringpayments-restapi/api/merchants/me/auth/oauth2', $oAuth2AuthenticationRequest);
    }

    /**
     * @param BasicAuthenticationRequest $basicAuthenticationRequest
     * @return mixed
     */
    public function putBasicAuthentication(BasicAuthenticationRequest $basicAuthenticationRequest) {
        return $this->mobilePayConnectionManager->put('/recurringpayments-restapi/api/merchants/me/auth/basic', $basicAuthenticationRequest);
    }


    /**
     * New calls, added in MobilePay Subscription 1.2.6
     */

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @return mixed
     */
    public function getRefunds(string $agreementRequestId, string $paymentRequestId) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/'.$agreementRequestId.'/payments/'.$paymentRequestId.'/refunds');
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param CreateRefundRequest $createRefundRequest
     * @return mixed
     */
    public function postRefunds(string $agreementRequestId, string $paymentRequestId, CreateRefundRequest $createRefundRequest) {
        return $this->mobilePayConnectionManager->post('/subscriptions/api/merchants/me/agreements/'.$agreementRequestId.'/payments/'.$paymentRequestId.'/refunds', $createRefundRequest);
    }

}