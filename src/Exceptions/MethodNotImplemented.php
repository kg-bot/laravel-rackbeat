<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.59
 */

namespace Rackbeat\Exceptions;


class MethodNotImplemented extends \Exception
{

    protected $message = 'This method is not implemented on given resource.';
}