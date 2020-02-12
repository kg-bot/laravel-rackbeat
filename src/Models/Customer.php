<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Builders\CustomerContactBuilder;
use Rackbeat\Utils\Model;

class Customer extends Model
{

    protected $entity = 'customers';
    protected $primaryKey = 'number';

    public function contacts()
    {
        return $this->request->handleWithExceptions(function () {

            $builder = new CustomerContactBuilder($this->request, $this->{$this->url_friendly_id});

            return $builder->get();
        });
    }
}