<?php

namespace Rackbeat\Builders;


use Rackbeat\Models\Layout;

class LayoutBuilder extends Builder
{
    protected $entity = 'layouts';
    protected $model = Layout::class;
}