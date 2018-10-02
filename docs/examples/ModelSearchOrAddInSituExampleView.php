<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Views\View;

class ModelSearchOrAddInSituExampleView extends View
{
    /** @var ModelSearchOrAddInSituExampleModel $model **/
    protected $model;

    private $output = "";

    protected function createSubLeaves()
    {
        parent::createSubLeaves();

        $this->registerSubLeaf(
            new ContactSearchWithAddInSituControl("contactID", $this->model->addContact),
            new Button("Continue", "Continue", function(){
                // This is not good practice - just a shortcut to demonstrate the behaviour.
                if ($this->model->contactID){
                    $this->output = "<p>You selected contact ".$this->model->contactID."</p>";
                } elseif ($this->model->addContact->firstname) {
                    $this->output = "<p>You're adding ".$this->model->addContact->firstname." ".
                    $this->model->addContact->surname."</p>";
                } else {
                    $this->output = "<p>You must select or add a contact</p>";
                }
            })
        );
    }

    protected function printViewContent()
    {
        if ($this->output){
            print $this->output;
        } else {
            print $this->leaves["contactID"];
            print $this->leaves["Continue"];
        }
    }
}
