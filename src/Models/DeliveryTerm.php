<?php

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class DeliveryTerm extends Model
{
	protected $entity     = 'delivery-terms';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;
}