<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Leaves\Leaf;

class ModelSearchOrAddControlExample extends Leaf
{
    /** @var ModelSearchOrAddControlExampleModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return ModelSearchOrAddControlExampleView::class;
    }

    protected function createModel()
    {
        return new ModelSearchOrAddControlExampleModel();
    }
}
