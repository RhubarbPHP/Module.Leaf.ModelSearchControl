<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\ModelSelectionControls\AddingModelLeafInterface;

class AddContactInSitu extends Leaf
{
    private $bindingSource;

    public function __construct(&$bindingSource)
    {
        $this->bindingSource = &$bindingSource;

        parent::__construct();
    }


    /** @var AddContactModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return AddContactInSituView::class;
    }

    protected function createModel()
    {
        return new AddContactInSituModel($this->bindingSource);
    }
}
