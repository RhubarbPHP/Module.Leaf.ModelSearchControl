<?php

namespace Rhubarb\Leaf\ModelSelectionControls;

use Rhubarb\Stem\Models\Model;

trait ModelSelectionControlTrait
{
    protected function convertValueToModel($value)
    {
        return null;
    }

    /**
     * When an item is selected, the return value of this method provides the string that represents the chosen item.
     *
     * By default this is the result of calling `getLabel()` on the model class.
     */
    protected function getLabelForModel(Model $model)
    {
        if (!$model) {
            return "";
        }

        return $model->getLabel();
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

        return $model->exportPublicData();
    }

    protected function makeItemForValue($value)
    {
        $model = $this->convertValueToModel($value);

        if ($model){
            return $this->makeItem($value, $this->getLabelForModel($model), $this->getDataForModel($model));
        }

        return $this->makeItem($value, "", []);
    }
}