<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class CustomerInvoice extends Model
{

    protected $entity = 'customer-invoices';
    protected $primaryKey = 'number';

    /**
     * Book customer invoice
     *
     * @param bool|array $send_email [optional] <p>
     * This parameter indicates should the mail be sent to customer,
     * if you send it as array it must be in format like this:
     * [
     *     "send" => false,
     *     "body" => "Something",
     *     "subject" => "YOUR SUBJECT",
     *     "receivers" => [
     *         "to" => [ "email@here.com"],
     *         "cc" => ["cc-email@here.com"],
     *         "bcc" => ["bcc1-email@here.com", "bcc2@here.com"]
     *     ]
     * ]
     * If you set send to false or use ->book(true) email body won't be included
     * </p>
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function book($send_email = false)
    {
        return $this->request->handleWithExceptions(function () use ($send_email) {

            $query = '';
            $body = [];

            if (is_bool($send_email)) {

                $query = ($send_email === true) ? '?send_mail=true' : '';
            } else if (is_array($send_email)) {

                $body = [

                    'mail' => $send_email,
                ];
            }

            $response = $this->request->client->post("{$this->entity}/{$this->url_friendly_id}/book" . $query, [
                'json' => $body,
            ]);

            $this->request->sleepIfRateLimited($response);

            return json_decode((string)$response->getBody());
        });
    }

    public function getPDF()
    {
        return $this->request->handleWithExceptions(function () {
            $response = $this->request->client->get("{$this->entity}/{$this->url_friendly_id}.pdf");

            $this->request->sleepIfRateLimited($response);

            return json_decode((string)$response->getBody());
        });
    }
}