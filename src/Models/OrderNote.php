<?php

namespace Rackbeat\Models;

use Rackbeat\Utils\Model;

class OrderNote extends Model
{
    protected $entity = 'orders/:number/notes';
    protected $primaryKey = 'id';

}
