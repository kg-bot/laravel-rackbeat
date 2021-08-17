<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\Webhook;

class WebhookBuilder extends Builder
{
    protected $entity = 'webhooks';
    protected $model  = Webhook::class;

    /**
    *
    * @param int $id
    *      
    * */
    public function deleteWebhook($id)
    {
        $id = rawurlencode( rawurlencode( $id ) );

        return $this->request->handleWithExceptions( function () use ( $id ) {
            $response     = $this->request->client->delete( "{$this->entity}/{$id}" );
        } );
    }
}