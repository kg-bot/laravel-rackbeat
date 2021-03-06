<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.53
 */

namespace Rackbeat\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Rackbeat\Exceptions\RackbeatClientException;
use Rackbeat\Exceptions\RackbeatRequestException;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class Request
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * Request constructor.
     *
     * @param null $token
     * @param array $options
     * @param array $headers
     * @param bool $enable_log
     * @param null $log_path
     */
    public function __construct($token = null, $options = [], $headers = [], $enable_log = false, $log_path = null)
    {
        $token = $token ?? Config::get('rackbeat.token');
        $headers = array_merge($headers, [

            'User-Agent' => Config::get('rackbeat.user_agent'),
            'Accept' => 'application/json; charset=utf8',
            'Content-Type' => 'application/json; charset=utf8',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $options = $this->addCustomMiddlewares($options, $enable_log, $log_path);

        $options = array_merge($options, [

            'base_uri' => Config::get('rackbeat.base_uri'),
            'headers' => $headers,
        ]);
        $this->client = new Client($options);
    }

    /**
     * @param $callback
     *
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function handleWithExceptions( $callback )
    {
        try {

            return $callback();

        } catch ( ClientException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new RackbeatRequestException( $message, $code );

        } catch ( ServerException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new RackbeatRequestException($message, $code);

        } catch (\Exception $exception) {

            $message = $exception->getMessage();
            $code = $exception->getCode();

            throw new RackbeatClientException($message, $code);
        }
    }

    public function createThrottleMiddleware()
    {
        return RateLimiterMiddleware::perMinute(Config::get('rackbeat.api_limit', 480), new RateLimiterStore());
    }

    public function createLoggerMiddleware($log_path = null)
    {
        $log_path = $log_path ?? 'guzzle-logger.log';

        $logger = new Logger('GuzzleCustomLogger');
        $location = storage_path('logs/' . $log_path);
        $logger->pushHandler(new StreamHandler($location, Logger::DEBUG));

        $format =
            '{method} {uri} - {target} - {hostname} HTTP/{version} .......... ' .
            'REQUEST HEADERS: {req_headers} ....... REQUEST: {req_body} ' .
            '......... RESPONSE HEADERS: {res_headers} ........... RESPONSE: {code} - {res_body}';
        return Middleware::log(
            $logger,
            new MessageFormatter($format)
        );
    }

    public function addCustomMiddlewares(array $options, $log, $log_path)
    {
        if (!empty($options['handler'])) {
            $options['handler']->push($this->createThrottleMiddleware());
        } else {
            $stack = HandlerStack::create();

            $stack->push($this->createThrottleMiddleware());
            $options['handler'] = $stack;
        }

        if ($log) {

            $options['handler']->push($this->createLoggerMiddleware($log_path));
        }

        return $options;
    }
}
