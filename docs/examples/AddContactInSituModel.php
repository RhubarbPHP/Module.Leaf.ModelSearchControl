<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class AddContactInSituModel extends LeafModel
{
    public function __construct(&$bindingSource)
    {
        parent::__construct();

        $this->bindingSource = &$bindingSource;
    }
}
