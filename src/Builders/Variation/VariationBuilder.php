<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders\Variation;


use Rackbeat\Builders\Builder;
use Rackbeat\Models\Variation\Variation;

class VariationBuilder extends Builder
{

    protected $entity = 'variations';
    protected $model  = Variation::class;
}