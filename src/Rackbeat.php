<?php

namespace Rackbeat;


use Rackbeat\Builders\CustomerBuilder;
use Rackbeat\Builders\CustomerContactBuilder;
use Rackbeat\Builders\CustomerGroupBuilder;
use Rackbeat\Builders\CustomerInvoiceBuilder;
use Rackbeat\Builders\DeliveryTermBuilder;
use Rackbeat\Builders\DraftOrderBuilder;
use Rackbeat\Builders\DraftPurchaseOrderBuilder;
use Rackbeat\Builders\EmployeeBuilder;
use Rackbeat\Builders\FieldBuilder;
use Rackbeat\Builders\InventoryAdjustmentBuilder;
use Rackbeat\Builders\InventoryMovementBuilder;
use Rackbeat\Builders\LayoutBuilder;
use Rackbeat\Builders\LineableBuilder;
use Rackbeat\Builders\LocationBuilder;
use Rackbeat\Builders\LotBuilder;
use Rackbeat\Builders\OrderBuilder;
use Rackbeat\Builders\OrderNoteBuilder;
use Rackbeat\Builders\OrderShipmentBuilder;
use Rackbeat\Builders\PaymentTermBuilder;
use Rackbeat\Builders\PluginBuilder;
use Rackbeat\Builders\ProductBuilder;
use Rackbeat\Builders\ProductGroupBuilder;
use Rackbeat\Builders\ProductionOrderBuilder;
use Rackbeat\Builders\PurchaseOrderBuilder;
use Rackbeat\Builders\SettingsBuilder;
use Rackbeat\Builders\SupplierBuilder;
use Rackbeat\Builders\SupplierContactBuilder;
use Rackbeat\Builders\SupplierGroupBuilder;
use Rackbeat\Builders\SupplierInvoiceBuilder;
use Rackbeat\Builders\Variation\VariationBuilder;
use Rackbeat\Builders\WebhookBuilder;
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
     * @param null $token API token
     * @param array $options Custom Guzzle options
     * @param array $headers Custom Guzzle headers
     * @param bool $enable_log
     * @param null $log_path
     */
    public function __construct($token = null, $options = [], $headers = [], $enable_log = false, $log_path = null)
    {
        $this->initRequest($token, $options, $headers, $enable_log, $log_path);
    }

    /**
     * @param $token
     * @param array $options
     * @param array $headers
     * @param bool $enable_log
     * @param null $log_path
     */
	private function initRequest( $token, $options = [], $headers = [], $enable_log = false, $log_path = null ): void {
		$this->request = new Request( $token, $options, $headers, $enable_log, $log_path );
	}

	/**
	 * @return \Rackbeat\Builders\SupplierBuilder
	 */
	public function suppliers(): SupplierBuilder {
		return new SupplierBuilder( $this->request );
	}

	/**
	 * @return SupplierGroupBuilder
	 */
	public function supplierGroups(): SupplierGroupBuilder {
		return new SupplierGroupBuilder( $this->request );
	}

	/**
	 * @return \Rackbeat\Builders\LocationBuilder
	 */
	public function locations() {
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
     * @return \Rackbeat\Builders\OrderNoteBuilder
     */
    public function orderNotes()
    {
        return new OrderNoteBuilder( $this->request );
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
	public function paymentTerms() {
		return new PaymentTermBuilder( $this->request );
	}

	/**
	 * @return DeliveryTermBuilder
	 */
	public function deliveryTerms() {
		return new DeliveryTermBuilder( $this->request );
	}

	/**
	 * @return \Rackbeat\Builders\ProductionOrderBuilder
	 */
	public function production_orders() {
		return new ProductionOrderBuilder( $this->request );
	}

	/**
	 * @return \Rackbeat\Builders\PurchaseOrderBuilder
	 */
	public function purchase_orders()
	{
		return new PurchaseOrderBuilder( $this->request );
	}

    /**
     * @return \Rackbeat\Builders\DraftOrderBuilder
     */
    public function draft_orders()
    {
        return new DraftOrderBuilder( $this->request );
    }

	/**
	 * @return \Rackbeat\Builders\DraftPurchaseOrderBuilder
	 */
	public function draft_purchase_orders()
	{
		return new DraftPurchaseOrderBuilder( $this->request );
	}

    /**
     * @return \Rackbeat\Builders\CustomerInvoiceBuilder
     */
    public function customer_invoices()
    {
        return new CustomerInvoiceBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\SupplierInvoiceBuilder
     */
    public function supplier_invoices()
    {
        return new SupplierInvoiceBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\WebhookBuilder
     */
    public function webhooks()
    {
        return new WebhookBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\PluginBuilder
     */
    public function user_account_plugins()
    {
        return new PluginBuilder( $this->request );
    }

    /**
     * @return \Rackbeat\Builders\OrderShipmentBuilder
     */
    public function order_shipments()
    {
        return new OrderShipmentBuilder($this->request);
    }

    /**
     * @return \Rackbeat\Builders\FieldBuilder
     */
    public function fields()
    {
        return new FieldBuilder($this->request);
    }

    /**
     * @return LayoutBuilder
     */
    public function layouts()
    {
        return new LayoutBuilder($this->request);
    }

    /**
     * This resource requires you to do $builder->setEntity and to replace {customer} in it with desired customer, otherwise it won't work
     *
     * @return CustomerContactBuilder
     */
    public function customer_contacts() {
	    return new CustomerContactBuilder( $this->request );
    }
    
    /**
     * This resource requires you to do $builder->setEntity and to replace {supplier} in it with desired supplier, otherwise it won't work
     *
     * @return SupplierContactBuilder
     */
    public function supplier_contacts() {
        return new SupplierContactBuilder( $this->request );
    }

	/**
	 * @return SettingsBuilder
	 */
	public function settings(): SettingsBuilder {
		return new SettingsBuilder( $this->request );
	}

	/**
	 * @return LineableBuilder
	 */
	public function lineables(): LineableBuilder {
		return new LineableBuilder( $this->request );
	}

	/**
	 * @return mixed
	 */
	public function self() {
		$response = $this->request->client->get( 'self' );


		return json_decode( (string) $response->getBody() );
    }
}