<?php

namespace Rackbeat\Builders;


use Rackbeat\Models\DeliveryTerm;

class DeliveryTermBuilder extends Builder
{

	protected $entity = 'delivery-terms';
	protected $model  = DeliveryTerm::class;
}