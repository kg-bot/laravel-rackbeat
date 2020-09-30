<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.02
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class Webhook extends Model
{
	public    $number;
	protected $entity     = 'webhooks';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;
}