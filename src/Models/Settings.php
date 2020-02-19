<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Exceptions\MethodNotImplemented;
use Rackbeat\Utils\Model;

class Settings extends Model
{

    protected $entity = 'settings';
    protected $primaryKey = 'id';

    public function delete()
    {
        throw new MethodNotImplemented();
    }

}