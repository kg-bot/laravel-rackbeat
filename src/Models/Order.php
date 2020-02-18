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
    protected $entity     = 'orders';
    protected $primaryKey = 'number';

    public function getPDF()
    {
        return $this->request->handleWithExceptions( function () {
            return $this->request->client->get("{$this->entity}/{$this->url_friendly_id}.pdf")->getBody()
                ->getContents();
        } );
    }

    public function reopen()
    {

        return $this->request->handleWithExceptions( function () {

            return $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/reopen")
                ->getBody()
                ->getContents();
        } );
    }

    public function createShipment()
    {
        return $this->request->handleWithExceptions(function () {

            $response = json_decode((string)$this->request->client->post("{$this->entity}/{$this->url_friendly_id}/create-shipment")
                ->getBody());

            return new OrderShipment($this->request, $response->order_shipment);
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

            $response = json_decode((string)$this->request->client->post("{$this->entity}/{$this->url_friendly_id}/convert-to-invoice?book=" . (($book === true) ? 'true' : 'false'), [
                'json' => $request,
            ])->getBody(), false);

            $invoice = (new CustomerInvoiceBuilder($this->request))->find($response->invoice_id);

            return $invoice;
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
