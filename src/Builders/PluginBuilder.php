<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Exceptions\MethodNotImplemented;
use Rackbeat\Models\Plugin;

class PluginBuilder extends Builder
{
    protected $entity = 'user-account-plugins';
    protected $model  = Plugin::class;

    public function create( $data )
    {
        throw new MethodNotImplemented();
    }
}