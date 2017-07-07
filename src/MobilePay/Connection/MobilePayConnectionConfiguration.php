<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 12:04
 */
namespace Luxplus\MobilePay\Connection;

class MobilePayConnectionConfiguration {

    private $certificateCRT;
    private $certificatePEM;
    private $certificatePassword;
    private $clientID;
    private $clientSecret;
    private $serverURL;
    private $debug;


    /**
     * MobilePayConnectionConfiguration constructor.
     * @param $certificateCRT
     * @param $certificatePEM
     * @param $certificatePassword
     * @param $clientID
     * @param $clientSecret
     * @param $serverURL
     * @param $debug
     */
    private function __construct($certificateCRT, $certificatePEM, $certificatePassword, $clientID, $clientSecret, $serverURL, $debug) {
        $this->certificateCRT = $certificateCRT;
        $this->certificatePEM = $certificatePEM;
        $this->certificatePassword = $certificatePassword;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->serverURL = $serverURL;
        $this->debug = $debug;
    }

    /**
     * @param $certificateCRT
     * @param $certificatePEM
     * @param $certificatePassword
     * @param $clientID
     * @param $clientSecret
     * @param $serverURL
     * @param bool $debug
     * @return MobilePayConnectionConfiguration
     */
    public static function createInstance($certificateCRT, $certificatePEM, $certificatePassword, $clientID, $clientSecret, $serverURL, $debug = false) {
        return new self($certificateCRT, $certificatePEM, $certificatePassword, $clientID, $clientSecret, $serverURL, $debug);
    }

    /**
     * @return mixed
     */
    public function getCertificateCRT() {
        return $this->certificateCRT;
    }

    /**
     * @return mixed
     */
    public function getCertificatePEM() {
        return $this->certificatePEM;
    }

    /**
     * @return mixed
     */
    public function getCertificatePassword() {
        return $this->certificatePassword;
    }

    /**
     * @return mixed
     */
    public function getClientID() {
        return $this->clientID;
    }

    /**
     * @return mixed
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * @return mixed
     */
    public function getServerURL() {
        return $this->serverURL;
    }

    /**
     * @return mixed
     */
    public function getDebug() {
        return $this->debug;
    }

}