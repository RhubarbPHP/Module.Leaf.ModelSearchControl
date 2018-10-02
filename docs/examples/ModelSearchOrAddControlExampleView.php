<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class ModelSearchOrAddControlExampleView extends View
{
    /** @var ModelSearchOrAddControlExampleModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        parent::createSubLeaves();

        $this->registerSubLeaf(
            new ContactSearchWithAddControl("contactID")
        );
    }

    protected function printViewContent()
    {
        print $this->leaves["contactID"];
    }
}
