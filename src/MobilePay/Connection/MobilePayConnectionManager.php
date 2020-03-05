<?php

/**
 * Created by PhpStorm.
 * User: Nikolaj Gammelmark
 * Date: 18-04-2017
 * Time: 12:17
 */
namespace Luxplus\MobilePay\Connection;

class MobilePayConnectionManager {

    private static $instance = [];


    /**
     * @param MobilePayConnectionConfiguration $mobilePayConfiguration
     * @param string|null $instance
     * @return MobilePayConnection
     */
    public static function getInstance(MobilePayConnectionConfiguration $mobilePayConfiguration, string $instance = null) {
        if(is_null($instance))
            $instance = 'default';

        if(!isset(self::$instance[$instance])) {
            self::$instance[$instance] = new MobilePayConnection($mobilePayConfiguration);
        }

        return self::$instance[$instance];
    }


}