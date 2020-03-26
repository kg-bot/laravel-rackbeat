<?php

namespace Rackbeat\Utils;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class GuzzleLoggerInstance
{
    protected $stack;

    public function __construct($file = null)
    {
        $file = $file ?? 'guzzle-logger.log';

        $logger = new Logger('GuzzleCustomLogger');
        $location = storage_path('logs/' . $file);
        $logger->pushHandler(new StreamHandler($location, Logger::DEBUG));

        $format =
            '{method} {uri} - {target} - {hostname} HTTP/{version} .......... ' .
            'REQUEST HEADERS: {req_headers} ....... REQUEST: {req_body} ' .
            '......... RESPONSE HEADERS: {res_headers} ........... RESPONSE: {code} - {res_body}';
        $stack = HandlerStack::create();
        $stack->push(
            Middleware::log(
                $logger,
                new MessageFormatter($format)
            )
        );

        $this->stack = $stack;
    }

    public function getStack()
    {
        return $this->stack;
    }
}
