<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-09-2017
 * Time: 13:52
 */
namespace Luxplus\MobilePay\Response;

class ErrorResponse {

    private $error;
    private $message;
    private $error_type;
    private $correlation_id;
    private $fullResponse;

    private function __construct() {
    }

    /**
     * Takes a stdClass after the response is encoded.
     * @param \stdClass|null $stdClass
     * @return ErrorResponse
     */
    public static function createInstance(\stdClass $stdClass = null) {
        $instance = new self();
        if($stdClass != null) {
            $instance->error = isset($stdClass->error)?$stdClass->error:null;
            $instance->message = isset($stdClass->error_description->message)?$stdClass->error_description->message:null;
            $instance->error_type = isset($stdClass->error_description->error_type)?$stdClass->error_description->error_type:null;
            $instance->correlation_id = isset($stdClass->error_description->correlation_id)?$stdClass->error_description->correlation_id:null;
            $instance->fullResponse = $stdClass;
        }
        return $instance;
    }

    /**
     * Get Overall Error.
     * @return string
     */
    public function getError() {
        return $this->error?:"No Error.";
    }

    /**
     * Get Message.
     * @return string
     */
    public function getMessage() {
        return $this->message?:"No Message.";
    }

    /**
     * Get Error Type.
     * @return string
     */
    public function getErrorType() {
        return $this->error_type?:"No Error Type.";
    }

    /**
     * Get Correlation Id if giving.
     * @return string
     */
    public function getCorrelationId() {
        return $this->correlation_id?:"No Correlation Id.";
    }

    public function getFullResponse() {
        return $this->fullResponse;
    }
}