<?php

namespace App\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionQueue 
{

    private static $connection;

    private function __construct()
    {}

    public static function get() 
    {
        if (self::$connection == null) {
            self::$connection = new AMQPStreamConnection(
                getenv("QUEUE_HOST"), getenv("QUEUE_PORT"), 
                getenv("QUEUE_USERNAME"), getenv("QUEUE_PASSWORD")
            );
        }

        return self::$connection;
    }

    public static function close()
    {
        self::$connection = null;
    }
}