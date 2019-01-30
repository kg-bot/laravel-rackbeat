<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\SupplierInvoice;

class SupplierInvoiceBuilder extends Builder
{
    protected $entity = 'supplier-invoices';
    protected $model  = SupplierInvoice::class;
}