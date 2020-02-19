<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Exceptions\MethodNotImplemented;
use Rackbeat\Models\Settings;

class SettingsBuilder extends Builder
{
    protected $entity = 'settings';
    protected $model = Settings::class;

    public function create($data)
    {
        throw new MethodNotImplemented();
    }
}