<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\Customer;

class CustomerBuilder extends Builder
{
    protected $entity = 'customers';
    protected $model  = Customer::class;
}