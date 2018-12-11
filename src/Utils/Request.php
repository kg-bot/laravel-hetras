<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.53
 */

namespace Hetras\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Hetras\Exceptions\HetrasClientException;
use Hetras\Exceptions\HetrasRequestException;

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
    public function __construct( $app_id = null, $app_key = null, $options = [], $headers = [] )
    {
        $headers      = array_merge( $headers, [

            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'App-Id'       => $app_id ?? config( 'hetras.app_id' ),
            'App-Key'      => $app_key ?? config( 'hetras.app_key' ),
        ] );
        $options      = array_merge( $options, [

            'base_uri' => config( 'hetras.base_uri' ),
            'headers'  => $headers,
        ] );
        $this->client = new Client( $options );
    }

    /**
     * @param $callback
     *
     * @return mixed
     * @throws \Hetras\Exceptions\HetrasClientException
     * @throws \Hetras\Exceptions\HetrasRequestException
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

            throw new HetrasRequestException( $message, $code );

        } catch ( ServerException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new HetrasRequestException( $message, $code );

        } catch ( \Exception $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            throw new HetrasClientException( $message, $code );
        }
    }
}