<?php

namespace App\Queue;

class Consumer
{

    private $queue;

    private $connection;

    private $channel;

    private $action;

    public function __construct()
    {
        $this->connection = ConnectionQueue::get();
        $this->channel = $this->connection->channel();
    }

    public function withQueue(String $queue)
    {
        $this->channel->queue_declare(
            $queue, false, false, false, false
        );
        $this->queue = $queue;
        return $this;
    }

    public function withAction(callable $action)
    {
        $this->action = $action;
        return $this;
    }

    public function consume()
    {
        $this->channel->basic_consume(
            $this->queue, '', false,
            true, false, false,
            $this->action
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

}