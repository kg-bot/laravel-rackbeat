<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.12
 */

namespace Rackbeat;


use Rackbeat\Builders\LocationBuilder;
use Rackbeat\Builders\ProductBuilder;
use Rackbeat\Builders\SupplierBuilder;
use Rackbeat\Utils\Request;

class Rackbeat
{
    protected $request;

    public function __construct( $token = null )
    {
        $this->initRequest();
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

    private function initRequest()
    {
        $this->request = new Request();
    }
}