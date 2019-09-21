<?php

namespace App\Queue;

use PhpAmqpLib\Message\AMQPMessage;

class Publisher
{

    private $queue;

    private $message;

    private $exchange = "";

    private $connection;

    private $channel;

    public function __construct()
    {
        $this->connection = ConnectionQueue::get();
        $this->channel = $this->connection->channel();
    }

    public function withQueue(String $queue)
    {
        $this->channel->queue_declare($queue, false, false, false, false);
        $this->queue = $queue;
        return $this;
    }

    public function withMessage($message)
    {
        $this->message = new AMQPMessage($message);
        return $this;
    }

    public function publish()
    {
        \AMQPExchange::
        $this->channel->basic_publish($this->message, $this->exchange, $this->queue);
        $this->channel->close();
        $this->connection->close();
        ConnectionQueue::close();

    }

}