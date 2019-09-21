<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

$connection = \App\Queue\ConnectionQueue::get();
$channel = $connection->channel();

$channel->exchange_declare(
    "topic_logs", \PhpAmqpLib\Exchange\AMQPExchangeType::TOPIC,
    false, false, false
);

$routeKey = isset($argv[1]) && !empty($argv[2]) ? $argv[1] : "anonymous.info";
$message = implode(",", array_slice($argv, 2));

if (empty($message)) {
    $message = "Hello world!";
}

$message = new \PhpAmqpLib\Message\AMQPMessage($message);

$channel->basic_publish($message, "topic_logs", $routeKey);

echo "Send message using route key: ${routeKey} \n";

$channel->close();
$connection->close();