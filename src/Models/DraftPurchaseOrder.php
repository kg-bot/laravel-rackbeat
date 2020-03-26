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
            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}.pdf");


            return json_decode((string)$response->getBody());
        } );
    }
}
