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
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Rackbeat\Exceptions\RackbeatClientException;
use Rackbeat\Exceptions\RackbeatRequestException;

class Request
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * Request constructor.
     *
     * @param null  $token
     * @param array $options
     * @param array $headers
     */
    public function __construct( $token = null, $options = [], $headers = [] )
    {
        $token = $token ?? Config::get('rackbeat.token');
        $headers = array_merge($headers, [

            'User-Agent' => Config::get('rackbeat.user_agent'),
            'Accept' => 'application/json; charset=utf8',
            'Content-Type' => 'application/json; charset=utf8',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $options      = array_merge( $options, [

            'base_uri' => Config::get('rackbeat.base_uri'),
            'headers' => $headers,
        ] );
        $this->client = new Client( $options );
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

    /**
     * Check to see if we are about to rate limit and pause if necessary.
     *
     * @param Response $response
     */
    public function sleepIfRateLimited(Response $response)
    {
        $remaining = $response->getHeader('X-RateLimit-Remaining')[0];
        $allowed = $response->getHeader('X-RateLimit-Limit')[0];

        if ($remaining === 0) {
            sleep(60 / Confid::get('rackbeat.api_limit'));
        }
    }
}
