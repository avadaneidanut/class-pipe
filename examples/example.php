<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use ClassPipe\Examples\Classes\Logger;

// creating new logger example class
$logger = new Logger;

// no subscribers except default
$logger->store('Hello', 'Dan');
$logger->show();

// adding subscriber to store pipe
$logger->subscriber('store', function($message, $owner){
	print("$owner says $message" . PHP_EOL);
});

// calling store method again after adding subscriber
$logger->store('Hello', 'Aligator');

// show all registered pipes
$logger->pipes();