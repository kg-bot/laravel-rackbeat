<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class OrderShipment extends Model
{
    protected $entity     = 'order-shipments';
    protected $primaryKey = 'id';

    public function markShipped()
    {
        return $this->request->handleWithExceptions(function () {

            return $this->request->client->post("orders/shipments/{$this->{$this->primaryKey}}/mark-shipped")
                ->getBody()
                ->getContents();
        });
    }
}
