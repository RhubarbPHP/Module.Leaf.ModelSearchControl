<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\NumericTextBox;
use Rhubarb\Leaf\Controls\Common\Text\NumericTextBoxView;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class AddContactView extends View
{
    /** @var AddContactModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        $this->registerSubLeaf(
            new TextBox("firstname"),
            new TextBox("surname"),
            new NumericTextBox("age",0),
            new Button("AddContact", "Add Contact", function(){
                $contact = $this->model->addContactEvent->raise();

                return $contact;
            }, true)    // true is important here - it must be an XHR event of some sort.
        );
    }

    protected function printViewContent()
    {
        $this->layoutItemsWithContainer("",
            [
               "firstname",
               "surname",
               "age",
                "" => "{AddContact} <button class='js-cancel-add'>Cancel</button>"
            ]);
    }

    public function getDeploymentPackage()
    {
        return new LeafDeploymentPackage(__DIR__ . '/AddContactViewBridge.js');
    }

    protected function getViewBridgeName()
    {
        return 'AddContactViewBridge';
    }
}
