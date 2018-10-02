<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Leaf\ModelSelectionControls\ModelSearchOrAddControl;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AnyWordsGroup;
use Rhubarb\Stem\Models\Model;

class ContactSearchWithAddControl extends ModelSearchOrAddControl
{
    public function __construct($name = null)
    {
        parent::__construct($name, new AddContact());
    }

    protected function createCollection($matchingPhrase = "")
    {
        return ContactExample::find(
            new AnyWordsGroup(["firstname", "surname"], $matchingPhrase)
        )
            ->addSort("firstname")
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