<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 17.00
 */

namespace Rackbeat\Builders;

use Illuminate\Support\Collection;
use Rackbeat\Utils\Model;
use Rackbeat\Utils\Request;


class Builder
{
    protected $entity;
    /** @var Model */
    protected $model;
    protected $request;

    public function __construct(Request $request )
    {
        $this->request = $request;
    }


    /**
     * Get only first page of resources, you can also set query parameters, default limit is 1000
     *
     * @param array $filters
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function get($filters = [] )
    {
        $filters[] = [ 'limit', '=', 1000 ];

        $urlFilters = $this->parseFilters( $filters );

        return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

            $response = $this->request->client->get("{$this->entity}{$urlFilters}");

            $this->request->sleepIfRateLimited($response);

            $responseData = json_decode((string)$response->getBody());
            $fetchedItems = collect($responseData);
            $items = collect([]);
            $pages = $responseData->pages;

            foreach ($fetchedItems->first() as $index => $item) {


                /** @var Model $model */
                $model = new $this->model( $this->request, $item );

                $items->push( $model );


            }

            return $items;
        } );
    }

    protected function parseFilters($filters = [] )
    {

        $limit = array_search('limit', array_column($filters, 0));
        if ($limit !== false && $limit !== (count($filters) - 1)) {

            unset($filters[count($filters) - 1]);
        }

        $urlFilters = '';

        if ( count( $filters ) > 0 ) {

            $filters = array_unique($filters, SORT_REGULAR);

            $i = 1;

            $urlFilters .= '?';

            foreach ($filters as $filter ) {

                $sign = !empty($filter[2]) ? $filter[1] : '=';
                $value = $filter[2] ?? $filter[1];

                $urlFilters .= $filter[0] . $sign . urlencode($value);

                if (count($filters) > $i) {

                    $urlFilters .= '&';
                }

                $i++;
            }
        }

        return $urlFilters;
    }

    /**
     * It will iterate over all pages until it does not receive empty response, you can also set query parameters,
     * default limit per page is 1000
     *
     * @param array $filters
     * @return mixed
     */
    public function all($filters = [] )
    {
        $page = 1;

        $items = collect();

        $response = function ( $filters, $page ) {

            /**
             * Default filters, limit must be always set last otherwise it will not work
             */
            $filters[] = [ 'page', '=', $page ];
            $filters[] = ['limit', '=', 1000];

            $urlFilters = $this->parseFilters( $filters );

            return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

                $response = $this->request->client->get("{$this->entity}{$urlFilters}");

                $this->request->sleepIfRateLimited($response);

                $responseData = json_decode((string)$response->getBody());
                $fetchedItems = collect($responseData);
                $items = collect([]);
                $pages = $responseData->pages;

                foreach ($fetchedItems->first() as $index => $item) {


                    /** @var Model $model */
                    $model = new $this->model( $this->request, $item );

                    $items->push( $model );


                }

                return (object) [

                    'items' => $items,
                    'pages' => $pages,
                ];
            } );
        };

        do {

            $resp = $response( $filters, $page );

            $items = $items->merge( $resp->items );
            $page++;
            sleep( 2 );

        } while ( $page <= $resp->pages );


        return $items;

    }

    /**
     * Find single resource by its id filed, it also accepts query parameters
     *
     * @param $id
     * @param array $filters
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function find($id, $filters = [])
    {
        $urlFilters = $this->parseFilters($filters);
        $id = rawurlencode(rawurlencode($id));

        return $this->request->handleWithExceptions(function () use ($id, $urlFilters) {

            $response = $this->request->client->get("{$this->entity}/{$id}{$urlFilters}");

            $this->request->sleepIfRateLimited($response);

            $responseData = collect(json_decode((string)$response->getBody()));

            return new $this->model($this->request, $responseData->first());
        } );
    }

    /**
     * Create new resource and return created model
     *
     * @param $data
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function create( $data )
    {
        return $this->request->handleWithExceptions( function () use ( $data ) {

            $response = $this->request->client->post("{$this->entity}", [
                'json' => $data,
            ]);

            $this->request->sleepIfRateLimited($response);


            $responseData = collect(json_decode((string)$response->getBody()));

            return new $this->model($this->request, $responseData->first());
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
}
