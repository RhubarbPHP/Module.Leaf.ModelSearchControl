<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\NumericTextBox;
use Rhubarb\Leaf\Controls\Common\Text\NumericTextBoxView;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class AddContactInSituView extends View
{
    /** @var AddContactModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        $this->registerSubLeaf(
            new TextBox("firstname"),
            new TextBox("surname"),
            new NumericTextBox("age",0)
        );
    }

    protected function printViewContent()
    {
        $this->layoutItemsWithContainer("",
            [
               "firstname",
               "surname",
               "age"
            ]);
    }
}
