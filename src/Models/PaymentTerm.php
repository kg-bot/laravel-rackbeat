<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 22.13
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class PaymentTerm extends Model
{
    protected $entity     = 'payment-terms';
    protected $primaryKey = 'number';
}