<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 20-04-2017
 * Time: 12:42
 */

namespace Luxplus\MobilePay\Requests;
abstract class Request implements \JsonSerializable {

    public function __toString() {
        return $this->jsonSerialize();
    }

    public function toArray() {
        $reflection = new \ReflectionClass($this);
        $vars = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);
        $resultArray = [];
        foreach($vars as $var) {
            $var->setAccessible(true);
            $resultArray[$var->getName()] = $var->getValue($this);
            $var->setAccessible(false);
        }
        return $resultArray;
    }
}