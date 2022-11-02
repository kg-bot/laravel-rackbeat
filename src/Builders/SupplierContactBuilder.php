<?php

namespace Rackbeat\Builders;

use Rackbeat\Models\SupplierContact;
use Rackbeat\Utils\Request;

class SupplierContactBuilder extends Builder
{
    protected $entity = 'suppliers/{supplier}/contacts';
    protected $model = SupplierContact::class;

    public function __construct(Request $request, $supplier_number = null)
    {
        parent::__construct($request);

        if ($supplier_number) {
            $this->entity = str_replace('{supplier}', $supplier_number, $this->entity);
        }
    }
}