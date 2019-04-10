<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\OrderShipment;

class OrderShipmentBuilder extends Builder
{
    protected $entity = 'order-shipments';
    protected $model  = OrderShipment::class;
}