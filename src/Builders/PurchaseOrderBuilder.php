<?php

namespace Rackbeat\Builders;


use Rackbeat\Models\PurchaseOrder;

class PurchaseOrderBuilder extends Builder
{
    protected $entity = 'purchase-orders';
    protected $model  = PurchaseOrder::class;
}