<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 17.00
 */

namespace Hetras\Builders;

use Hetras\Utils\Model;
use Hetras\Utils\Request;


class Builder
{
    protected $entity;
    /** @var Model */
    protected $model;
    protected $hotelId;
    private   $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection|Model[]
     */
    public function get( $filters = [] )
    {
        $urlFilters = '?limit=1500';

        if ( count( $filters ) > 0 ) {

            $urlFilters .= '&filter=';
            $i          = 1;

            foreach ( $filters as $filter ) {

                $urlFilters .= $filter[ 0 ] . $this->switchComparison( $filter[ 1 ] ) .
                               $this->escapeFilter( $filter[ 2 ] ); // todo fix arrays aswell ([1,2,3,...] string)

                if ( count( $filters ) > $i ) {

                    $urlFilters .= '$and:'; // todo allow $or: also
                }

                $i++;
            }
        }

        return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

            $response     = $this->request->client->get( "{$this->entity}{$urlFilters}" );
            $responseData = json_decode( (string) $response->getBody() );
            $fetchedItems = collect( $responseData );
            $items        = collect( [] );

            foreach ( $fetchedItems->first() as $index => $item ) {


                /** @var Model $model */
                $model = new $this->model( $this->request, $item );

                if ( $model->needHotelId() ) {

                    $model->setHotelId( $this->hotelId );
                }

                $items->push( $model );


            }

            return $items;
        } );
    }

    private function switchComparison( $comparison )
    {
        switch ( $comparison ) {
            case '=':
            case '==':
                $newComparison = '$eq:';
                break;
            case '!=':
                $newComparison = '$ne:';
                break;
            case '>':
                $newComparison = '$gt:';
                break;
            case '>=':
                $newComparison = '$gte:';
                break;
            case '<':
                $newComparison = '$lt:';
                break;
            case '<=':
                $newComparison = '$lte:';
                break;
            case 'like':
                $newComparison = '$like:';
                break;
            case 'in':
                $newComparison = '$in:';
                break;
            case '!in':
                $newComparison = '$nin:';
                break;
            default:
                $newComparison = "${$comparison}:";
                break;
        }

        return $newComparison;
    }

    private function escapeFilter( $variable )
    {
        $escapedStrings    = [
            "$",
            '(',
            ')',
            '*',
            '[',
            ']',
            ',',
        ];
        $urlencodedStrings = [
            '+',
            ' ',
        ];
        foreach ( $escapedStrings as $escapedString ) {

            $variable = str_replace( $escapedString, '$' . $escapedString, $variable );
        }
        foreach ( $urlencodedStrings as $urlencodedString ) {

            $variable = str_replace( $urlencodedString, urlencode( $urlencodedString ), $variable );
        }

        return $variable;
    }

    public function find( $id )
    {
        return $this->request->handleWithExceptions( function () use ( $id ) {

            $response     = $this->request->client->get( "{$this->entity}/{$id}" );
            $responseData = json_decode( (string) $response->getBody() );

            $model = new $this->model( $this->request, $responseData );

            if ( $model->needHotelId() ) {

                $model->setHotelId( $this->hotelId );
            }

            return $model;
        } );
    }

    public function create( $data )
    {
        return $this->request->handleWithExceptions( function () use ( $data ) {

            $response = $this->request->client->post( "{$this->entity}", [
                'json' => $data,
            ] );

            $responseData = collect( json_decode( (string) $response->getBody() ) );

            return new $this->model( $this->request, $responseData->first() );
        } );
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity( $new_entity )
    {
        $this->entity = $new_entity;

        return $this->entity;
    }

    public function needHotelId()
    {
        return strpos( $this->entity, '{hotelId}' ) !== false;
    }

    public function setHotelId( $hotelId )
    {
        $this->hotelId = $hotelId;
        $this->entity  = str_replace( '{hotelId}', $hotelId, $this->entity );
    }
}