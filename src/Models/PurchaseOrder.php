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
            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}.pdf");

            $this->request->sleepIfRateLimited($response);

            return json_decode((string)$response->getBody());
        } );
    }

    public function reopen()
    {

        return $this->request->handleWithExceptions( function () {

            $response = $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/reopen");

            $this->request->sleepIfRateLimited($response);

            return json_decode((string)$response->getBody());
        } );
    }
}
