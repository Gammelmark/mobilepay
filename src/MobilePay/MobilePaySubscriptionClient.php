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
use Luxplus\MobilePay\Exceptions\BadRequestException;
use Luxplus\MobilePay\Exceptions\CurlException;
use Luxplus\MobilePay\Exceptions\IdNotProvidedException;
use Luxplus\MobilePay\Exceptions\InternalServerErrorException;
use Luxplus\MobilePay\Exceptions\NotFoundException;
use Luxplus\MobilePay\Exceptions\PreconditionFailedException;
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
     * @var MobilePayConnectionManager $mobilePayConnectionManager
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
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getAgreementRequests(string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements', $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getAgreementRequest(string $agreementRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId, $correlationId);
    }

    /**
     * @param CreateAgreementRequest $agreementRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function postAgreementRequest(CreateAgreementRequest $agreementRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->post("/subscriptions/api/merchants/me/agreements", $agreementRequest, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function deleteAgreementRequest(string $agreementRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->delete('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param UpdateAgreementRequest $agreementRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function patchAgreementRequest(string $agreementRequestId, UpdateAgreementRequest $agreementRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->patch("/subscriptions/api/merchants/me/agreements/" . $agreementRequestId, $agreementRequest, $correlationId);
    }


    /**
     * @param string $agreementRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getPaymentRequests(string $agreementRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests', $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getPaymentRequest(string $agreementRequestId, string $paymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId, $correlationId);
    }

    /**
     * Takes an array of CreatePaymentRequest or an instance of CreatePaymentRequest.
     *
     * @param CreatePaymentRequest|array $paymentRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function postPaymentRequests($paymentRequest, string $correlationId = null) {
        if(is_array($paymentRequest)) {
            //Do nothing
        } elseif($paymentRequest instanceof CreatePaymentRequest) {
            $paymentRequest = [$paymentRequest];
        } else {
            throw new \InvalidArgumentException("The \$paymentRequest parameter must be an array or an instance of CreatePaymentRequest.");
        }
        return $this->postPaymentRequestsBatch($paymentRequest, $correlationId);
    }

    /**
     *
     * Takes only an array of CreatePaymentRequest.
     *
     * @param array $paymentRequestArray
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function postPaymentRequestsBatch(array $paymentRequestArray, string $correlationId = null) {
        foreach($paymentRequestArray as $paymentRequest) {
            if(!$paymentRequest instanceof CreatePaymentRequest) {
                throw new \InvalidArgumentException("Item in array is not an instance of class CreatePaymentRequest.");
            }
        }
        return $this->mobilePayConnectionManager->post('/subscriptions/api/merchants/me/paymentrequests', $paymentRequestArray, $correlationId);
    }


    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function deletePaymentRequest(string $agreementRequestId, string $paymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->delete('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param CreatePaymentRequest $paymentRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function patchPaymentRequest(string $agreementRequestId, string $paymentRequestId, CreatePaymentRequest $paymentRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->patch('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/paymentrequests/' . $paymentRequestId, $paymentRequest, $correlationId);
    }


    /**
     * @param string $agreementRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getOneOffPayments(string $agreementRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments', $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $oneOffPaymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getOneOffPayment(string $agreementRequestId, string $oneOffPaymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $oneOffPaymentRequestId, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param CreateOneOffPaymentRequest $oneOffPaymentRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function postOneOffPayment(string $agreementRequestId, CreateOneOffPaymentRequest $oneOffPaymentRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->post('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments', $oneOffPaymentRequest, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $oneOffPaymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function deleteOneOffPayment(string $agreementRequestId, string $oneOffPaymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->delete('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $oneOffPaymentRequestId, $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function captureOneOffPayment(string $agreementRequestId, string $paymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->post('/subscriptions/api/merchants/me/agreements/' . $agreementRequestId . '/oneoffpayments/' . $paymentRequestId . '/capture', $correlationId);
    }


    /**
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getMerchantConfiguration(string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me', $correlationId);
    }

    /**
     * @param UpdateMerchantRequest $updateMerchantRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function patchMerchantConfiguration(UpdateMerchantRequest $updateMerchantRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->patch('/subscriptions/api/merchants/me', $updateMerchantRequest, $correlationId);
    }

    /**
     * @param ApiKeyAuthenticationRequest $apiKeyAuthenticationRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function putAPIKeyAuthentication(ApiKeyAuthenticationRequest $apiKeyAuthenticationRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->put('/subscriptions/api/merchants/me/auth/apikey', $apiKeyAuthenticationRequest, $correlationId);
    }

    /**
     * @param OAuth2AuthenticationRequest $oAuth2AuthenticationRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function putOAuth2Authentication(OAuth2AuthenticationRequest $oAuth2AuthenticationRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->put('/subscriptions/api/merchants/me/auth/oauth2', $oAuth2AuthenticationRequest, $correlationId);
    }

    /**
     * @param BasicAuthenticationRequest $basicAuthenticationRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function putBasicAuthentication(BasicAuthenticationRequest $basicAuthenticationRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->put('/subscriptions/api/merchants/me/auth/basic', $basicAuthenticationRequest, $correlationId);
    }


    /**
     * New calls, added in MobilePay Subscription 1.2.6
     */

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function getRefunds(string $agreementRequestId, string $paymentRequestId, string $correlationId = null) {
        return $this->mobilePayConnectionManager->get('/subscriptions/api/merchants/me/agreements/'.$agreementRequestId.'/payments/'.$paymentRequestId.'/refunds', $correlationId);
    }

    /**
     * @param string $agreementRequestId
     * @param string $paymentRequestId
     * @param CreateRefundRequest $createRefundRequest
     * @param string|null $correlationId
     * @return mixed
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function postRefunds(string $agreementRequestId, string $paymentRequestId, CreateRefundRequest $createRefundRequest, string $correlationId = null) {
        return $this->mobilePayConnectionManager->post('/subscriptions/api/merchants/me/agreements/'.$agreementRequestId.'/payments/'.$paymentRequestId.'/refunds', $createRefundRequest, $correlationId);
    }

    /**
     * TODO: should be moved.
     *
     * Returns a GUID string (32 alphanumeric characters + 4 hyphens = 36 total characters) to use for correlationId
     * @return string
     */
    public function createGUID() {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}