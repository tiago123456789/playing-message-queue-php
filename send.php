<?php


require_once __DIR__ . "/vendor/autoload.php";

\App\Config\EnvironmentVariable::load();

(new \App\Queue\Publisher())
        ->withMessage("Hi, message queue!")
        ->withQueue("hi_queue")
        ->publish();