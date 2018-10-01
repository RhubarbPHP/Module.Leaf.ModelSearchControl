<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\ModelSelectionControls\ModelSearchControl;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AnyWordsGroup;
use Rhubarb\Stem\Models\Model;

class ContactSearchControl extends ModelSearchControl
{
    public function __construct($name = "", $modelClassName)
    {
        parent::__construct($name, $modelClassName);
    }

    protected function createCollection($matchingPhrase = "")
    {
        return ContactExample::find(
            new AnyWordsGroup(["firstname", "surname"], $matchingPhrase)
        )->addSort("firstname")
         ->addSort("surname");
    }

    protected function getResultColumns()
    {
        return ["firstname", "surname"];
    }

    protected function getDataColumns()
    {
        return ["age"];
    }

    protected function getLabelForModel(Model $model)
    {
        return $model->firstname." ".$model->surname." (".$model->age.")";
    }

    protected function convertValueToModel($value)
    {
        try {
            return new ContactExample($value);
        } catch (RecordNotFoundException $er){
        }

        return null;
    }
}