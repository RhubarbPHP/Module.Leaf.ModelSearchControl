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

use Rhubarb\Leaf\Controls\Common\SelectionControls\SearchControl\SearchControl;
use Rhubarb\Stem\Collections\Collection;
use Rhubarb\Stem\Collections\RepositoryCollection;
use Rhubarb\Stem\Filters\Contains;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\SolutionSchema;

abstract class ModelSearchControl extends SearchControl
{
    use ModelSelectionControlTrait;

    /**
     * Returns an array of model column names to include in each item's javascript representation
     *
     * This allows the javascript to make smart use of the selected item's properties without returning
     * to the server to fetch them.
     *
     * It is however extremely important that you do not include private columns that would cause a
     * data breach if exposed publically.
     *
     * @return array
     */
    protected function getDataColumns()
    {
        return [];
    }

    /**
     * Blends the data required to satisfy the result columns and the data columns.
     *
     * @param $model
     * @return array|string[]
     */
    protected function getDataForModel(Model $model)
    {
        if (!$model) {
            return [];
        }

        $data = [];

        // Make sure all the result columns are populated.
        foreach($this->getResultColumns() as $resultColumn){
            $data[$resultColumn] = $model[$resultColumn];
        }

        // Make sure additional data columns are there to.
        foreach($this->getDataColumns() as $dataColumn){
            $data[$dataColumn] = $model[$dataColumn];
        }

        return $data;
    }

    /**
     * Returns collection to represent the items matched by the supplied phrase
     * @param string $matchingPhrase The phrase entered by the user
     * @return Collection
     */
    protected abstract function createCollection($matchingPhrase = "");

    protected function getCurrentlyAvailableSelectionItems()
    {
        if ($this->model->searchPhrase == "") {
            return [];
        }

        $list = $this->createCollection($this->model->searchPhrase);

        $results = [];

        foreach ($list as $item) {
            $result = $this->makeItem($item->getUniqueIdentifier(), $this->getLabelForModel($item), $this->getDataForModel($item));
            $results[] = $result;
        }

        return $results;
    }

    protected function getViewClass()
    {
        return ModelSearchControlView::class;
    }
}
