<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\ProductionOrder;

class ProductionOrderBuilder extends Builder
{
    protected $entity = 'production-orders';
    protected $model  = ProductionOrder::class;
}