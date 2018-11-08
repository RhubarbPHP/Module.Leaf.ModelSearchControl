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

use Rhubarb\Leaf\Controls\Common\SelectionControls\SearchControl\SearchControlView;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;
use Rhubarb\Stem\Models\Model;

class ModelSearchOrAddControlView extends SearchControlView
{
    protected $requiresContainerDiv = true;
    
    /**
     * @var $model ModelSearchOrAddControlModel
     */
    protected $model;

    protected function createSubLeaves()
    {
        parent::createSubLeaves();

        $this->registerSubLeaf($this->model->addLeaf);

        if ($this->model->addLeaf instanceof AddingModelLeafInterface) {
            $this->model->addLeaf->getItemAddedEvent()->attachHandler(function (Model $model) {
                return $this->model->getItemForModelEvent->raise($model);
            });
        }
    }

    public function printViewContent()
    {

        ?>
        <div class="u-pos-relative c-super-search-container">
            <label class="c-label"></label>
                <?= parent::printViewContent() ?>
            <div class="u-pos-relative">
                <div class="c-loader c-loader--input" style="display: none"></div>
            </div>
        </div>
        <?php

        if ($this->model->addLeaf != null) {
            print $this->model->addLeaf;
        }
    }

    protected function getViewBridgeName()
    {
        return "ModelSearchOrAddControlViewBridge";
    }

    public function getDeploymentPackage()
    {
        $package = parent::getDeploymentPackage();
        $package->resourcesToDeploy[] = __DIR__ . "/ModelSearchOrAddControlViewBridge.js";

        return $package;
    }
}