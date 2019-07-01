<?php

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class DraftPurchaseOrder extends Model
{
    protected $entity     = 'purchase-orders/drafts';
    protected $primaryKey = 'number';

    public function getPDF()
    {
        return $this->request->handleWithExceptions( function () {
            return $this->request->client->get( "{$this->entity}/{$this->{$this->primaryKey}}.pdf" )->getBody()
                                         ->getContents();
        } );
    }
}
