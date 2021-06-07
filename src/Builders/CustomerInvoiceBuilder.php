<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\CustomerInvoice;

class CustomerInvoiceBuilder extends Builder
{
    protected $entity = 'customer-invoices';
    protected $model  = CustomerInvoice::class;
    
    /**
     * Mark invoice as booked
     *
     * @param $number
     *
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function markBook( $number )
    {
        return $this->request->handleWithExceptions( function () use ( $number ) {

            $response     = $this->request->client->post( $this->entity . '/' . $number . '/book' );
            $responseData = $this->getResponse( $response );
        } );
    }    
}
