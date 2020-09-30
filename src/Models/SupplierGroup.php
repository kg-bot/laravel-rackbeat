<?php
/**
 * Created by PhpStorm.
 * User: kgbot
 * Date: 5/5/18
 * Time: 11:54 PM
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class SupplierGroup extends Model
{
	protected $entity     = 'supplier-groups';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;
}