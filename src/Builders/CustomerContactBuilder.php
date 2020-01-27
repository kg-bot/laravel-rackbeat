<?php

namespace Rackbeat\Builders;

use Rackbeat\Models\CustomerContact;
use Rackbeat\Utils\Request;

class CustomerContactBuilder extends Builder
{
    protected $entity = 'customers/{customer}/contacts';
    protected $model = CustomerContact::class;

    public function __construct(Request $request, $customer_number = null)
    {
        parent::__construct($request);

        if ($customer_number) {
            $this->entity = str_replace('{customer}', $customer_number, $this->entity);
        }
    }
}