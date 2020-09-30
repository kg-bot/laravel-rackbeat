<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class ProductionOrder extends Model
{
	protected $entity     = 'production-orders';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;

	public function getPDF() {
		return $this->request->handleWithExceptions( function () {
			$response = $this->request->client->get( "{$this->entity}/{$this->url_friendly_id}.pdf" );


			return json_decode( (string) $response->getBody() );
		} );
	}
}
