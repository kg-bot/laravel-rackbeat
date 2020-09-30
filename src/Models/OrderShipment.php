<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class OrderShipment extends Model
{
	protected $entity     = 'order-shipments';
	protected $primaryKey = 'id';
	protected $modelClass = self::class;

	/**
	 * Mark shipment as shipped
	 *
	 * @param bool $pick Mark all shipment lines as picked
	 *
	 * @return mixed
	 * @throws \Rackbeat\Exceptions\RackbeatClientException
	 * @throws \Rackbeat\Exceptions\RackbeatRequestException
	 */
	public function markShipped( $pick = true )
    {
        return $this->request->handleWithExceptions(function () use ($pick) {

            $response = $this->request->client->post("orders/shipments/{$this->url_friendly_id}/mark-shipped", [

                'json' => [

                    'pick' => $pick,
                ],
            ]);


            return json_decode((string)$response->getBody());
        });
    }
}
