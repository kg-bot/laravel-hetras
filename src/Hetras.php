<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.12
 */

namespace Hetras;


use Hetras\Builders\FolioBuilder;
use Hetras\Builders\HouseAccountBuilder;
use Hetras\Utils\Request;

class Hetras
{
    /**
     * @var $request Request
     */
    protected $request;

    /**
     * Hetras constructor.
     *
     * @param null  $token   API token
     * @param array $options Custom Guzzle options
     * @param array $headers Custom Guzzle headers
     */
    public function __construct( $app_id = null, $app_key = null, $options = [], $headers = [] )
    {
        $this->initRequest( $app_id, $app_key, $options, $headers );
    }

    private function initRequest( $app_id, $app_key, $options = [], $headers = [] )
    {
        $this->request = new Request( $app_id, $app_key, $options, $headers );
    }

    public function folios( $hotelId )
    {
        $builder = new FolioBuilder( $this->request );

        $builder->setHotelId( $hotelId );

        return $builder;
    }

    public function house_accounts( $hotelId )
    {
        $builder = new HouseAccountBuilder( $this->request );

        $builder->setHotelId( $hotelId );

        return $builder;
    }

}