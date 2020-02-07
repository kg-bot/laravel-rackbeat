<?php

namespace Rackbeat\Builders;

use Rackbeat\Models\OrderNote;

class OrderNoteBuilder extends Builder
{
    protected $entity = 'orders/:number/notes';
    protected $model = OrderNote::class;
}