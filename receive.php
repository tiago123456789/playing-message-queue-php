<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

(new \App\Queue\Consumer())
    ->withQueue("hi_queue")
    ->withAction(function($message) {
        print_r($message->body) . "\n";
    })
    ->consume();