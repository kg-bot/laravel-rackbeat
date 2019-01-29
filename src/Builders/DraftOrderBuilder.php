<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\DraftOrder;

class DraftOrderBuilder extends Builder
{
    protected $entity = 'draft-orders';
    protected $model  = DraftOrder::class;
}