<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

$connection = \App\Queue\ConnectionQueue::get();
$channel = $connection->channel();
$channel->exchange_declare(
    "log", \PhpAmqpLib\Exchange\AMQPExchangeType::FANOUT,
    false, false, false
);

list($queueName, , ) = $channel->queue_declare("", false, false, true, false);

$channel->queue_bind($queueName, "log");

$channel->basic_consume(
    $queueName, "", false, true,
    false, false, function($message) {
        echo $message->body . "\n";
    });

while($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
