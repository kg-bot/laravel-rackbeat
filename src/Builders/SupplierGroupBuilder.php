<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\SupplierGroup;

class SupplierGroupBuilder extends Builder
{
    protected $entity = 'supplier-groups';
    protected $model  = SupplierGroup::class;
}