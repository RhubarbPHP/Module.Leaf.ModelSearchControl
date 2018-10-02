<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\Leaves\LeafModel;

class ModelSearchOrAddInSituExampleModel extends LeafModel
{
    public $addContact;

    public function __construct()
    {
        $this->addContact = new \stdClass();
        parent::__construct();
    }
}
