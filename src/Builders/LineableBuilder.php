<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\Lot;
use Rackbeat\Models\Product;

class LineableBuilder extends Builder
{

	protected $entity       = 'lineables';
	protected $productClass = Product::class;
	protected $lotClass     = Lot::class;

	protected function getModelClass( $item ) {
		if ( $item->type === 'product' ) {
			return $this->productClass;
		}

		return $this->lotClass;
	}
}