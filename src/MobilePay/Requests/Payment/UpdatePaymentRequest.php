<?php
/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 20-04-2017
 * Time: 14:25
 */

namespace Luxplus\MobilePay\Requests\Payment;


use Luxplus\MobilePay\Requests\Request;

class UpdatePaymentRequest extends Request {

    private $items;
    private $allowedPaths = ["amount"];
    private $allowedOperations =  ["replace"];

    private function __construct() {
    }

    public static function createInstance() {
        $instance = new self();
        return $instance;
    }

    public function addItem(string $value, string $path, string $op = 'replace', string $from = null) {
        //only these properties are allowed
        if(!in_array($path, $this->allowedPaths))
            throw new \InvalidArgumentException("Available properties: ".implode(",",$this->allowedPaths).". Property supplied: '".$path."''.");
        //only op(eration) allowed for now are: replace
        if(!in_array($op, $this->allowedOperations))
            throw new \InvalidArgumentException("Available properties: replace. Property supplied: '".$op."''.");

        $item["value"] = $value;
        $item["path"] = $path;
        $item["op"] = $op;

        if($from != null)
            $item["from"] = $from;

        $this->items[] = $item;
    }

    public function jsonSerialize() {
        if($this->items == null)
            throw new \InvalidArgumentException('Items array is empty. Please use addItem() to add new items.');
        return $this->items;
    }



}