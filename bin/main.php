#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

define('ROOT_DIR', dirname(__DIR__));

require_once(ROOT_DIR . '/vendor/autoload.php');

// Get the app version
$data = json_decode(ROOT_DIR . '/composer.json');
$version = isset($data->version) ? $data->version : 'dev';

// Set up the app
$app = new Application('vh', $version);
$app->addCommands(array(
    new \JPry\VVVHelper\Command\AddSite(),
));

// Add our custom helper.
$helpers = $app->getHelperSet();
$helpers->set(new \JPry\VVVHelper\Helpers\Prompter());

// Run it!
$app->run();
