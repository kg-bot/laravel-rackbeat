<?php

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class PurchaseOrder extends Model
{
    protected $entity     = 'purchase-orders';
    protected $primaryKey = 'number';

    public function getPDF()
    {
        return $this->request->handleWithExceptions( function () {
            return $this->request->client->get( "{$this->entity}/{$this->{$this->primaryKey}}.pdf" )->getBody()
                                         ->getContents();
        } );
    }

    public function reopen()
    {

        return $this->request->handleWithExceptions( function () {

            return $this->request->client->post( "{$this->entity}/{$this->{$this->primaryKey}}/reopen" )
                                         ->getBody()
                                         ->getContents();
        } );
    }
}
