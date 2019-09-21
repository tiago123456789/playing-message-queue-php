<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

$connection = \App\Queue\ConnectionQueue::get();
$channel = $connection->channel();

$channel->exchange_declare(
    "topic_logs", \PhpAmqpLib\Exchange\AMQPExchangeType::TOPIC,
    false, false, false
);

list($queueName, ,) = $channel->queue_declare("", false, false, true, false);

$bindingKeys = array_slice($argv, 1);

if (empty($bindingKeys)) {
    file_put_contents("php://stderr", "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach ($bindingKeys as $bindingKey) {
    $channel->queue_bind($queueName, "topic_logs", $bindingKey);
}

$channel->basic_consume(
    $queueName, '', false,
    true, false, false, function($message) {
        echo $message->body . "\n";
    });

while($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
