<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 17:41
 */

namespace Luxplus\MobilePay\Connection;


use Luxplus\MobilePay\Requests\Request;

class MobilePayConnection {

    /**
     * @var MobilePayConnectionConfiguration
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
     * @return mixed
     */
    public function get(string $uri,  Request $request = null) {
        return $this->connect($uri, $request, 'GET');
    }

    /**
     * @param string $uri
     * @param Request|null $requst
     * @return mixed
     */
    public function delete(string $uri,  Request $requst = null) {
        return $this->connect($uri, $requst, 'DELETE');
    }

    /**
     * @param string $uri
     * @param Request|null $request
     * @return mixed
     */
    public function post(string $uri,  Request $request = null) {
        return $this->connect($uri, $request, 'POST');
    }

    /**
     * @param string $uri
     * @param Request|null $request
     * @return mixed
     */
    public function patch(string $uri, Request $request = null) {
        return $this->connect($uri, $request, 'PATCH');
    }

    /**
     * @param string $uri
     * @param Request|null $request
     * @return mixed
     */
    public function put(string $uri,  Request $request = null) {
        return $this->connect($uri, $request, 'PUT');
    }

    /**
     * @param string $uri
     * @param Request|null $request
     * @param string $requestType
     * @return mixed
     * @throws \Exception
     */
    private function connect(string $uri, Request $request = null, string $requestType) {
        if(!is_resource($this->ch))
            $this->ch = curl_init();


        curl_setopt($this->ch, CURLOPT_VERBOSE, $this->mobilePayConnectionConfiguration->getDebug());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $requestType);

        if($request != null)
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $request->toJSON());

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

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->ch);
        $response = json_decode($response);

        if(curl_errno($this->ch)) {
            echo 'Error:' . curl_error($this->ch);
            //TODO: proper Exception handling
            throw new \Exception(curl_error($this->ch));
        }
        $responseInformation = curl_getinfo($this->ch);
        curl_close($this->ch);

        if($responseInformation["http_code"] == 500)
            throw new \Exception("General server or application error.");
        if($responseInformation["http_code"] == 400) {
            throw new \Exception("Something's wrong with request body. ".$response->error_description->message);
        }
        if($responseInformation["http_code"] == 404) {
            throw new \Exception("Not found. ".$response->error_description->message);
        }
        if($responseInformation["http_code"] == 405) {
            throw new \Exception("Id not provided. ".$response->error_description->message);
        }
        if($responseInformation["http_code"] == 412) {
            throw new \Exception("Request didn't meet all business requirements. ".$response->error_description->message);
        }

        return $response;
    }
}