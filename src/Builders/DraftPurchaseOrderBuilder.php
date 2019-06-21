<?php

namespace Rackbeat\Builders;


use Rackbeat\Models\DraftPurchaseOrder;

class DraftPurchaseOrderBuilder extends Builder
{
    protected $entity = 'purchase-orders/drafts';
    protected $model  = DraftPurchaseOrder::class;
}