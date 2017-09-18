<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-09-2017
 * Time: 10:08
 */

namespace Luxplus\MobilePay\Exceptions;


use Luxplus\MobilePay\Response\ErrorResponse;

class MobilePayException extends \Exception {

    /**
     * @var ErrorResponse $errorResponseObject
     */
    protected $errorResponseObject;

    public function __construct(\stdClass $message = null, $code = 0) {
        $this->errorResponseObject = ErrorResponse::createInstance($message);
        $this->message .= " ".$this->getErrorResponseObject()->getMessage()."CorrelationID: ". ($this->getErrorResponseObject()->getCorrelationId()?:"None")."\r\n";
        parent::__construct($this->message, $code);
    }

    /**
     * Get entire ErrorResponse object
     * @return ErrorResponse
     */
    public function getErrorResponseObject() {
        return $this->errorResponseObject;
    }
}