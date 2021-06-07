<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace Rackbeat\Models;


use Rackbeat\Builders\CustomerInvoiceBuilder;
use Rackbeat\Builders\OrderNoteBuilder;
use Rackbeat\Builders\OrderShipmentBuilder;
use Rackbeat\Utils\Model;

class Order extends Model
{
	public $shipment_id;
	protected $entity     = 'orders';
	protected $primaryKey = 'number';
	protected $modelClass = self::class;

	public function getPDF() {
		return $this->request->handleWithExceptions( function () {
			$response = $this->request->client->get( "{$this->entity}/{$this->url_friendly_id}.pdf" );


			return json_decode( (string) $response->getBody() );
		} );
	}

    public function reopen()
    {

        return $this->request->handleWithExceptions( function () {

            $response = $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/reopen");


            return json_decode((string)$response->getBody());
        } );
    }

    public function createShipment()
    {
        return $this->request->handleWithExceptions(function () {

            $response = $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/create-shipment");


            return new OrderShipment($this->request, json_decode((string)$response->getBody())->order_shipment);
        });
    }

    public function shipments()
    {
        return $this->request->handleWithExceptions(function () {

            $builder = new OrderShipmentBuilder($this->request);

            return $builder->get([
                ['order_number', '=', $this->url_friendly_id],
            ]);
        });
    }

    /**
     * @param bool $book Should the invoice be booked
     * @return CustomerInvoice
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function convertToInvoice($book = false, $request = [])
    {
        return $this->request->handleWithExceptions(function () use ($book, $request) {

            $response = $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/convert-to-invoice?book=" . (($book === true) ? 'true' : 'false'), [
                'json' => $request,
            ]);


            return (new CustomerInvoiceBuilder($this->request))->find(json_decode((string)$response->getBody(), false)->invoice_id);
        });
    }

    public function notes()
    {
        return $this->request->handleWithExceptions(function () {

            $builder = new OrderNoteBuilder($this->request);
            $builder->setEntity(str_replace(':number', $this->url_friendly_id, $builder->getEntity()));

            return $builder->get();
        });
    }
}
