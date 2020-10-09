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
	public    $id;
	public    $event;
	public    $url;
	public    $is_active;
	public    $created_at;
	public    $updated_at;
	protected $entity     = 'webhooks';
	protected $primaryKey = 'id';
	protected $modelClass = self::class;
}