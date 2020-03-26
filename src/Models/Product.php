<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.02
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class Product extends Model
{
    public    $number;
    protected $entity     = 'products';
    protected $primaryKey = 'number';

    public function inventoryMatrix( $location_id = null, array $filter = null )
    {
        return $this->request->handleWithExceptions( function () use ( $location_id, $filter ) {

            $query = '';

            // We need to use location filter if user has provided any
            if ( !is_null( $location_id ) ) {

                $query .= '?location_id=' . $location_id;
            }

            if ( !is_null( $filter ) ) {

                foreach ( $filter as $parameter => $value ) {

                    if ( $query === '' ) {

                        $query .= '?' . $parameter . '=' . $value;

                    } else {

                        $query .= '&' . $parameter . '=' . $value;
                    }
                }
            }

            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}/variation-matrix" .
                $query);


            return json_decode((string)$response->getBody());
        } );

    }

    public function variations( $variation_id = 1001 )
    {
        return $this->request->handleWithExceptions( function () use ( $variation_id ) {

            $response = $this->request->client->get("variations/{$this->url_friendly_id}/variation-matrix");


            return json_decode((string)$response->getBody());
        } );
    }

    public function location($number = null)
    {
        return $this->request->handleWithExceptions(function () use ($number) {

            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}/locations" . (($number !== null) ? '/' . $number : ''));


            $response = json_decode((string)$response->getBody());

            if (isset($response->product_locations)) {

                return collect($response->product_locations);
            } else if (isset($response->product_location)) {

                return $response->product_location;
            } else {

                return $response;
            }


        } );
    }

    /**
     * Show reporting ledger for desired product https://app.rackbeat.com/reporting/ledger/{product_number}
     * API docs: https://rackbeat.docs.apiary.io/#reference/inventory-reports/show
     */
    public function ledger()
    {
        return $this->request->handleWithExceptions( function () {

            $response =
                $this->request->client->get("reports/ledger/{$this->{ $this->primaryKey } }");


            return collect(json_decode((string)$response->getBody())->ledger_items);

        } );
    }

    public function fields()
    {

        return $this->request->handleWithExceptions( function () {

            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}/fields");


            return collect(json_decode((string)$response->getBody())->field_values);

        } );
    }
}