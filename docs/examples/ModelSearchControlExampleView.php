<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;
use Rhubarb\Leaf\Views\View;

class ModelSearchControlExampleView extends View
{
    /** @var ModelSearchControlExampleModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        parent::createSubLeaves();

        $this->registerSubLeaf(
            new ContactSearchControl("contactID"),
            new ContactSearchControl("boundContactID")
        );
    }

    protected function printViewContent()
    {
        ?>
        <p>Try searching for "lin" or "John". Note that searching is slow in this example as each request is spawning
            500 example models in real time.</p>
        <p>Select a person to see how old they are - an example of using additional data columns.</p>
        <?php
        print $this->leaves["contactID"];
        ?>
        <p></p>
        <p>This is an example of a search control already bound to an existing value.</p>
        <?php
        print $this->leaves["boundContactID"];
    }

    protected function getViewBridgeName()
    {
        return "ModelSearchControlExampleViewBridge";
    }

    public function getDeploymentPackage()
    {
        return new LeafDeploymentPackage(
                __DIR__.'/ModelSearchControlExampleViewBridge.js',
                __DIR__.'/styles.css'
            );
    }
}