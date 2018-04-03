<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders\Variation;

use Rackbeat\Builders\Builder;
use Rackbeat\Models\Variation\TypeOption;

class TypeOptionBuilder extends Builder
{

    protected $entity = 'variations/:variation_number/types/:type_number/options';
    protected $model  = TypeOption::class;
}