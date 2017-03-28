<?php

require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;

// Create the logger
$logger = new Logger('my_logger');
$bubble = true;

$output = "%datetime% > %level_name% > %message% %context% %extra%\n";
// Create a formatter
$formatter = new LineFormatter($output);
$stream = new StreamHandler(__DIR__.'/my_app.log', Logger::INFO,$bubble);
//Configure a handler with the formatter
$stream->setFormatter($formatter);
$logger->pushHandler($stream);
$logger->pushProcessor(new PsrLogMessageProcessor());
$logger->pushProcessor(function ($record) {
    $record['extra']['hello'] = 'Hello PHPMad! #phplogs';
    return $record;
});

$logger->info('Info message {hello}', ['hello'=> 'holis!']);
$logger->debug('Debug message');
