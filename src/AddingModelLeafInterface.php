<?php

namespace Rhubarb\Leaf\ModelSelectionControls;

use Rhubarb\Crown\Events\Event;

interface AddingModelLeafInterface
{
    function getItemAddedEvent(): Event;
}