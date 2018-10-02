<?php
/**
 * Copyright (c) 2016 RhubarbPHP.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Rhubarb\Leaf\ModelSelectionControls;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Controls\Common\SelectionControls\SearchControl\SearchControlModel;
use Rhubarb\Leaf\Leaves\Leaf;

class ModelSearchOrAddControlModel extends SearchControlModel
{
    /**
     * @var Leaf
     */
    public $addLeaf;

    /**
     * @var Event
     */
    public $getItemForModelEvent;

    public function __construct()
    {
        $this->getItemForModelEvent = new Event();

        parent::__construct();
    }
}