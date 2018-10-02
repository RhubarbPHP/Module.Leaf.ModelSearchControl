<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Leaves\Leaf;

class ModelSearchOrAddInSituExample extends Leaf
{
    /** @var ModelSearchOrAddControlExampleModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return ModelSearchOrAddInSituExampleView::class;
    }

    protected function createModel()
    {
        return new ModelSearchOrAddInSituExampleModel();
    }
}
