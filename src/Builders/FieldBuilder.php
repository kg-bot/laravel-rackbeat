<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\Field;

class FieldBuilder extends Builder
{

    protected $entity = 'fields';
    protected $model  = Field::class;
}