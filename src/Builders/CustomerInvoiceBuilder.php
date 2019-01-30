<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\CustomerInvoice;

class CustomerInvoiceBuilder extends Builder
{
    protected $entity = 'customer-invoices';
    protected $model  = CustomerInvoice::class;
}