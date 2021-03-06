<?php

/*
 *	Copyright 2015 RhubarbPHP
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace Rhubarb\Leaf\ModelSelectionControls;

use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Stem\Models\Model;

/**
 * Extends ModelSearchControl with support for adding an item.
 */
abstract class ModelSearchOrAddControl extends ModelSearchControl
{
    use ModelSelectionControlTrait;

    protected $addLeaf;

    /**
     * @var ModelSearchOrAddControlModel
     */
    protected $model;

    /**
     * ModelSearchOrAddControl constructor.
     * @param $name
     * @param Leaf $addLeaf The leaf to show when adding an item.
     */
    public function __construct($name, Leaf $addLeaf)
    {
        $this->addLeaf = $addLeaf;

        parent::__construct($name);
    }

    protected function onModelCreated()
    {
        // Rename the presenter to make sure we can simplify how we access it.
        if ($this->addLeaf != null) {
            $this->addLeaf->setName("Add");
            $this->model->addLeaf = $this->addLeaf;
        }

        // Hook up the event handler that returns a selection item for a given model.
        $this->model->getItemForModelEvent->attachHandler(function(Model $model){
            return $this->makeItemForValue($model->getUniqueIdentifier());
        });

        parent::onModelCreated();
    }

    protected function createModel()
    {
        return new ModelSearchOrAddControlModel();
    }

    protected function getViewClass()
    {
        return ModelSearchOrAddControlView::class;
    }
}