<?php

namespace Rhubarb\Leaf\ModelSelectionControls;

abstract class ModelSearchOrAddInSituControl extends ModelSearchOrAddControl
{
    protected function createView()
    {
        return new ModelSearchOrAddInSituView($this->addPresenter);
    }

}