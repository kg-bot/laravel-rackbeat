<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;

use Rackbeat\Utils\Model;

class SupplierContact extends Model
{

	protected $entity     = 'suppliers/{supplier}/contacts';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;
}