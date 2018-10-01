<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Leaves\Leaf;

class ModelSearchControlExample extends Leaf
{
    /** @var ModelSearchControlExampleModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return ModelSearchControlExampleView::class;
    }

    protected function createModel()
    {
        return new ModelSearchControlExampleModel();
    }
}
