<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Exceptions\MethodNotImplemented;
use Rackbeat\Utils\Model;

class Plugin extends Model
{

	protected $entity     = 'user-account-plugins';
	protected $primaryKey = 'id';
	protected $modelClass = self::class;

	public function delete() {
		throw new MethodNotImplemented();
	}

	public function update( $data = [] ) {
		throw new MethodNotImplemented();
	}
}