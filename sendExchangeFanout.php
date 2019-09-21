<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

$connection = \App\Queue\ConnectionQueue::get();
$channel = $connection->channel();
$channel->exchange_declare(
    "log", \PhpAmqpLib\Exchange\AMQPExchangeType::FANOUT,
    false, false, false
);

$message = new \PhpAmqpLib\Message\AMQPMessage("Study message queue using exchange fanout");

$channel->basic_publish($message, "log");

$channel->close();
$connection->close();

