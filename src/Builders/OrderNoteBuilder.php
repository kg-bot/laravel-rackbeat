<?php

namespace Rackbeat\Builders;

use Rackbeat\Models\OrderNote;

class OrderNoteBuilder extends Builder
{
    protected $entity = 'orders/:number/notes';
    protected $model = OrderNote::class;

    public function createOrderNote($number, $data)
    {
        $this->setEntity(str_replace(':number', $number, $this->getEntity()));

        return $this->create($data);
    }
}