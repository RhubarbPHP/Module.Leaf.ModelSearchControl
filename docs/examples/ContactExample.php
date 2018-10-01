<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\BooleanColumn;
use Rhubarb\Stem\Schema\Columns\IntegerColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
use Rhubarb\Stem\Schema\ModelSchema;

class ContactExample extends Model
{

    /**
     * Returns the schema for this data object.
     *
     * @return \Rhubarb\Stem\Schema\ModelSchema
     */
    protected function createSchema()
    {
        $schema = new ModelSchema("contact");
        $schema->addColumn(
            new AutoIncrementColumn("id"),
            new StringColumn("firstname", 100),
            new StringColumn("surname", 100),
            new IntegerColumn("age"));

        $schema->labelColumnName = "firstname";
        
        return $schema;
    }
}