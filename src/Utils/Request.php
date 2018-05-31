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
use Rackbeat\Exceptions\RackbeatClientException;
use Rackbeat\Exceptions\RackbeatRequestException;

class Request
{
    public $client;

    public function __construct( $token = null )
    {
        $token        = $token ?? config( 'rackbeat.token' );
        $this->client = new Client( [

            'base_uri' => 'https://app.rackbeat.com/api/',
            'headers'  => [

                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ] );
    }

    public function handleWithExceptions( $callback )
    {
        try {
            return $callback();

        } catch ( ClientException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = $exception->getResponse()->getBody()->getContents();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new RackbeatRequestException( $message, $code );

        } catch ( ServerException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = $exception->getResponse()->getBody()->getContents();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new RackbeatRequestException( $message, $code );

        } catch ( \Exception $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            throw new RackbeatClientException( $message, $code );
        }
    }
}