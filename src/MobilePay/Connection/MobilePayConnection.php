<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 17:41
 */

namespace Luxplus\MobilePay\Connection;


use Luxplus\MobilePay\Exceptions\IdNotProvidedException;
use Luxplus\MobilePay\Exceptions\BadRequestException;
use Luxplus\MobilePay\Exceptions\CurlException;
use Luxplus\MobilePay\Exceptions\InternalServerErrorException;
use Luxplus\MobilePay\Exceptions\NotFoundException;
use Luxplus\MobilePay\Exceptions\PreconditionFailedException;
use Luxplus\MobilePay\Requests\Request;

class MobilePayConnection {

    /**
     * @var MobilePayConnectionConfiguration $mobilePayConnectionConfiguration
     */
    private $mobilePayConnectionConfiguration;
    private $ch;

    public function __construct(MobilePayConnectionConfiguration $mobilePayConnectionConfiguration) {
        $this->mobilePayConnectionConfiguration = $mobilePayConnectionConfiguration;
        $this->ch = curl_init();
    }
    public function __destruct() {
        if(isset($this->ch) && is_resource($this->ch))
            curl_close($this->ch);
    }

    /**
     * @param string $uri
     * @param Request|null $request
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
    public function get(string $uri,  Request $request = null, string $correlationId = null) {
        return $this->connect($uri, $request, 'GET', $correlationId);
    }

    /**
     * @param string $uri
     * @param Request|null $request
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
    public function delete(string $uri, Request $request = null, string $correlationId = null) {
        return $this->connect($uri, $request, 'DELETE', $correlationId);
    }

    /**
     * @param string $uri
     * @param Request|null $request
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
    public function post(string $uri,  Request $request = null, string $correlationId = null) {
        return $this->connect($uri, $request, 'POST', $correlationId);
    }

    /**
     * @param string $uri
     * @param Request|null $request
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
    public function patch(string $uri, Request $request = null, string $correlationId = null) {
        return $this->connect($uri, $request, 'PATCH', $correlationId);
    }

    /**
     * @param string $uri
     * @param Request|null $request
     * @return mixed
     * @param string|null $correlationId
     * @throws BadRequestException
     * @throws CurlException
     * @throws IdNotProvidedException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws PreconditionFailedException
     * @throws \HttpResponseException
     */
    public function put(string $uri,  Request $request = null, string $correlationId = null) {
        return $this->connect($uri, $request, 'PUT', $correlationId);
    }

    /**
     * @param string $uri
     * @param Request|array|null $request
     * @param string $requestType
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
    private function connect(string $uri, $request = null, string $requestType, string $correlationId = null) {
        if(!is_resource($this->ch))
            $this->ch = curl_init();

        if($this->ch === false) {
            throw new CurlException("curl failed to initialize. ".curl_error($this->ch));
        }

        curl_setopt($this->ch, CURLOPT_VERBOSE, $this->mobilePayConnectionConfiguration->getDebug());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $requestType);

        if(is_array($request)) {
            $serializedObjects = [];
            foreach($request as $item) {
                $serializedObjects[] = $item->jsonSerialize();
            }
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($serializedObjects));
        } else if($request != null)
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($request->jsonSerialize()));

        curl_setopt($this->ch, CURLOPT_URL, $this->mobilePayConnectionConfiguration->getServerURL().$uri);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, '2');
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, '1');

        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);


        curl_setopt($this->ch, CURLOPT_CAINFO, $this->mobilePayConnectionConfiguration->getCertificateCRT());
        curl_setopt($this->ch, CURLOPT_SSLCERT, $this->mobilePayConnectionConfiguration->getCertificatePEM());
        curl_setopt($this->ch, CURLOPT_SSLCERTPASSWD, $this->mobilePayConnectionConfiguration->getCertificatePassword());

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "x-ibm-client-id: " . $this->mobilePayConnectionConfiguration->getClientID();
        $headers[] = "x-ibm-client-secret: " . $this->mobilePayConnectionConfiguration->getClientSecret();

        if($correlationId != null) {
            $headers[] = "correlationid: " . $correlationId;
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->ch);
        if($response === false) {
            throw new CurlException("curl failed to execute. ".curl_error($this->ch));
        }
        $response = json_decode($response);

        if(curl_errno($this->ch)) {
            throw new CurlException(curl_error($this->ch));
        }
        $responseInformation = curl_getinfo($this->ch);
        if($responseInformation === false || !isset($responseInformation["http_code"])) {
            throw new CurlException("curl_getinfo() failed. ".curl_error($this->ch));
        }
        curl_close($this->ch);

        switch ($responseInformation["http_code"]) {
            //Accepted HTTP codes
            case 200:
            case 201:
            case 202:
            case 204:
                //do nothing
                break;

            //Not accepted HTTP codes
            case 400:
                throw new BadRequestException($response);
                break;
            case 404:
                throw new NotFoundException($response);
                break;
            case 405:
                throw new IdNotProvidedException($response);
                break;
            case 412:
                throw new PreconditionFailedException($response);
                break;
            case 500:
                throw new InternalServerErrorException($response);
                break;

            //All other codes are not accepted.
            default:
                throw new \HttpResponseException("Response HTTP code not accepted. HTTP code: ".$responseInformation["http_code"].". Please consult the documentation.");
                break;
        }
        return $response;
    }
}