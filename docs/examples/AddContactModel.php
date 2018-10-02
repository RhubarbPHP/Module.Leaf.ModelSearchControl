<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class AddContactModel extends LeafModel
{
    /**
     * Raised when a contact should be added.
     * 
     * @var Event
     */
    public $addContactEvent;

    public function __construct()
    {
        parent::__construct();

        $this->addContactEvent = new Event();
    }
}
