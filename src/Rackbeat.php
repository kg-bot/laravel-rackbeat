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
use Rackbeat\Builders\EmployeeBuilder;
use Rackbeat\Builders\InventoryAdjustmentBuilder;
use Rackbeat\Builders\InventoryMovementBuilder;
use Rackbeat\Builders\LocationBuilder;
use Rackbeat\Builders\LotBuilder;
use Rackbeat\Builders\OrderBuilder;
use Rackbeat\Builders\PaymentTermBuilder;
use Rackbeat\Builders\ProductBuilder;
use Rackbeat\Builders\ProductGroupBuilder;
use Rackbeat\Builders\ProductionOrderBuilder;
use Rackbeat\Builders\SupplierBuilder;
use Rackbeat\Builders\SupplierGroupBuilder;
use Rackbeat\Builders\Variation\VariationBuilder;
use Rackbeat\Utils\Request;

class Rackbeat
{
    /**
     * @var $request Request
     */
    protected $request;

    /**
     * Rackbeat constructor.
     *
     * @param null  $token   API token
     * @param array $options Custom Guzzle options
     * @param array $headers Custom Guzzle headers
     */
    public function __construct( $token = null, $options = [], $headers = [] )
    {
        $this->initRequest( $token, $options, $headers );
    }

    private function initRequest( $token, $options = [], $headers = [] )
    {
        $this->request = new Request( $token, $options, $headers );
    }

    /**
     * @return \Rackbeat\Builders\SupplierBuilder
     */
    public function suppliers()
    {
        return new SupplierBuilder( $this->request );
    }

    public function supplierGroups()
    {
        return new SupplierGroupBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\LocationBuilder
     */
    public function locations()
    {
        return new LocationBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\ProductBuilder
     */
    public function products()
    {
        return new ProductBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\LotBuilder
     */
    public function lots()
    {
        return new LotBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\ProductGroupBuilder
     */
    public function productGroups()
    {
        return new ProductGroupBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\Variation\VariationBuilder
     */
    public function variations()
    {
        return new VariationBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\OrderBuilder
     */
    public function orders()
    {
        return new OrderBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\CustomerBuilder
     */
    public function customers()
    {
        return new CustomerBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\CustomerGroupBuilder
     */
    public function customerGroups()
    {
        return new CustomerGroupBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\InventoryMovementBuilder
     */
    public function inventory_movements()
    {
        return new InventoryMovementBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\InventoryAdjustmentBuilder
     */
    public function inventory_adjustments()
    {
        return new InventoryAdjustmentBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\EmployeeBuilder
     */
    public function employees()
    {
        return new EmployeeBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\PaymentTermBuilder
     */
    public function paymentTerms()
    {
        return new PaymentTermBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\ProductionOrderBuilder
     */
    public function production_orders()
    {
        return new ProductionOrderBuilder( $this->request );
    }
}