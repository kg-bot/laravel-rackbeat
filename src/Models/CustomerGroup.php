<?php
/**
 * Created by PhpStorm.
 * User: kgbot
 * Date: 5/5/18
 * Time: 11:54 PM
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class CustomerGroup extends Model
{
	protected $entity     = 'customer-groups';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;
}