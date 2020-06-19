<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class SupplierInvoice extends Model
{

	protected $entity     = 'supplier-invoices';
	protected $primaryKey = 'number';

	/**
	 * Book supplier invoice
	 *
	 * @param bool $mark_as_received
	 * @param bool $use_invoice_date
	 *
	 * @return mixed
	 * @throws \Rackbeat\Exceptions\RackbeatClientException
	 * @throws \Rackbeat\Exceptions\RackbeatRequestException
	 */
	public function book( $mark_as_received = false, $use_invoice_date = false ) {
		return $this->request->handleWithExceptions( function () use ( $mark_as_received, $use_invoice_date ) {

			$data = [
				'mark_received'    => $mark_as_received,
				'use_invoice_date' => $use_invoice_date
			];

			$response = $this->request->client->post( "{$this->entity}/{$this->url_friendly_id}/book", [
				'json' => $data,
			] );


			return json_decode( (string) $response->getBody() );
		});
    }

    public function getPDF()
    {
        return $this->request->handleWithExceptions(function () {
            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}.pdf");


            return json_decode((string)$response->getBody());
        });
    }
}