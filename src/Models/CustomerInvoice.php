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

    public function book($send_email = false)
    {
        return $this->request->handleWithExceptions(function () use ($send_email) {

            return $this->request->client->post("{$this->entity}/{$this->{$this->primaryKey}}/book" . (($send_email === true) ? '?send_mail=true' : ''))
                ->getBody()
                ->getContents();
        });
    }
}