<?php

namespace Rhubarb\Leaf\ModelSelectionControls\Examples;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\ModelSelectionControls\AddingModelLeafInterface;

class AddContact extends Leaf implements AddingModelLeafInterface
{
    private $itemAddedEvent;

    public function __construct(string $name = null)
    {
        $this->itemAddedEvent = new Event();

        parent::__construct($name);
    }


    /** @var AddContactModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return AddContactView::class;
    }

    protected function createModel()
    {
        return new AddContactModel();
    }

    protected function onModelCreated()
    {
        parent::onModelCreated();

        $this->model->addContactEvent->attachHandler(function(){
           $contact = new ContactExample();
           $contact->firstname = $this->model->firstname;
           $contact->surname = $this->model->surname;
           $contact->age = $this->model->age;
           $contact->save();

           return $this->itemAddedEvent->raise($contact);
        });
    }

    public function getItemAddedEvent(): Event
    {
        return $this->itemAddedEvent;
    }
}
