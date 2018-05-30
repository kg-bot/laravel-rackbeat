<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.12
 */

namespace Rackbeat;


use Rackbeat\Builders\CustomerBuilder;
use Rackbeat\Builders\CustomerGroupBuilder;
use Rackbeat\Builders\InventoryAdjustmentBuilder;
use Rackbeat\Builders\InventoryMovementBuilder;
use Rackbeat\Builders\LocationBuilder;
use Rackbeat\Builders\LotBuilder;
use Rackbeat\Builders\OrderBuilder;
use Rackbeat\Builders\ProductBuilder;
use Rackbeat\Builders\ProductGroupBuilder;
use Rackbeat\Builders\SupplierBuilder;
use Rackbeat\Builders\Variation\VariationBuilder;
use Rackbeat\Utils\Request;

class Rackbeat
{
    protected $request;

    public function __construct( $token = null )
    {
        $this->initRequest( $token );
    }

    private function initRequest( $token )
    {
        $this->request = new Request( $token );
    }

    public function suppliers()
    {
        return new SupplierBuilder( $this->request );
    }

    public function locations()
    {
        return new LocationBuilder( $this->request );
    }

    public function products()
    {
        return new ProductBuilder( $this->request );
    }

    public function lots()
    {
        return new LotBuilder( $this->request );
    }

    public function productGroups()
    {
        return new ProductGroupBuilder( $this->request );
    }

    public function variations()
    {
        return new VariationBuilder( $this->request );
    }

    public function orders()
    {
        return new OrderBuilder( $this->request );
    }

    public function customers()
    {
        return new CustomerBuilder( $this->request );
    }

    public function customerGroups()
    {
        return new CustomerGroupBuilder( $this->request );
    }

    public function inventory_movements()
    {
        return new InventoryMovementBuilder( $this->request );
    }

    public function inventory_adjustments()
    {
        return new InventoryAdjustmentBuilder( $this->request );
    }
}