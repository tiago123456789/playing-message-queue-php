<?php

namespace App\Config;

use Dotenv\Dotenv;

class EnvironmentVariable
{

    private function __construct()
    {
    }

    public static function load()
    {
        $dotenv = Dotenv::create(__DIR__ . "/../../");
        $dotenv->load();
    }
}