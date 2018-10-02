Model Selection Controls  [packagist:rhubarbphp/module-leaf-modelselectioncontrols]
========================

The model selection controls module provides some extended selection controls that use
models and collections as their data source.

## ModelSearchControl

The `ModelSearchControl` extends `SearchControl` to provide a simple pattern for searching
among large recordsets provided by a collection.

`ModelSearchControl` is abstract so to use it you need to extend the class:

```php file[examples/ContactSearchControl.php] lines[8]
```

The following methods should be overriden to get the desired behaviour:

createCollection($matchingPhrase)
:   Returns a collection of model items filtered for the given phrase. Take care
    to sort the collection in the order you want items presented.
    
getResultColumns()
:   An array of columns from the model to present in the result list. The results
    are presented in a table by default - this can be changed like any search
    control by overriding the view bridge
    
getDataColumns()
:   An array of additional columns to include from the model in the items passed
    back to the client. This allows the client to process data for the selected
    items without having to go back to the server to fetch it. You must be careful
    however not to pass secret or secure information in this way however.
    
getLabelForModel($model)
:   Returns the label text to use for a given model. This label is displayed in
    place of the search item for a selected item. Default behaviour is to 
    return the result of the model's getLabel() function.
    
convertValueToModel($value)
:   When rendering a search control already bound to an existing value the search
    control must recreate the label and data for that item so it can be presented
    correctly and client javascript can interoperate with the item just
    as if it was newly selected. This function converts a simple id value back
    to an instance of your model. Normally this can be done by simply using your
    model constructor to find the model and return it - but be careful not to
    contravene any data boundaries in your application in case this is tampered 
    with.

### Demo 

``` demo[examples/ModelSearchControlExample.php,ContactSearchControl.php,ModelSearchControlExampleView.php,ModelSearchControlExampleViewBridge.js,styles.css]
```

## ModelSearchOrAddControl

Often you need to afford the user an opportunity to create a record if one cannot be found
in the available list. This control extends the basic ModelSearchControl with a pattern that
makes this straightforward.

Many different interfaces to capture the record details can be imagined - a modal dialog, an in-line
panel etc. The key is that you express your 'adding' interface through a dedicated leaf. This leaf
needs to be passed to the constructor of `ModelSearchOrAddControl`:

```php
class ContactSelection extends ModelSearchOrAddControl
{
    public function __construct($name = null)
    {
        // AddContact is the Leaf that can render a UI for adding a contact, and add the contact.
        parent::__construct($name, new AddContact());
    }
}
``` 

The adding Leaf must be able to raise a client event `ItemAdded` when the deed is done. It must
pass an argument to this event containing a selection item - just like any other selection item
used in selection controls. The structure of a selection item looks like this:

``` javascript
{
    "value": 1,
    "label": "John",
    "data": {
        "firstname": "John",
        "surname": "Smith"
     }
}
```

The `ModelSearchOrAddControl` will be listening for the ItemAdded event and will take this data
structure and make this the 'selected' item.

```javascript
rhubarb.vb.create('AddContactViewBridge', function() {
    return {
        attachEvents:function() {
            this.viewNode.querySelector('.js-add').addEventListener('click', function(event){    
                this.raiseServerEvent("addContact", function(contactId){
                    // Raise the event to let the search control know we've successfully added a new record.
                    // In this example we define our own item structure to give to the search control using the
                    // values extracted from our sub controls. This works ok for simple scenarios however
                    // it's easy for the PHP and client side versions of this to get out of sync leading
                    // to hard to spot bugs.
                    this.raiseClientEvent("ItemAdded", {
                        value: contactId,
                        label: this.findChildViewBridge('firstname').getValue() + ' ' + this.findChildViewBridge('surname').getValue(),
                        data: {
                            firstname: this.findChildViewBridge('firstname').getValue(),
                            surname: this.findChildViewBridge('surname').getValue(),
                            age: this.findChildViewBridge('age').getValue()
                            }
                        } 
                    });    
                }.bind(this));
            }.bind(this));
        }
    };
})
```

Once 'selected' the user will expect that the interface looks the same as if they'd just
searched for and selected the item. Rather than trying to match the item structure in your
add Leaf with that created by the search control it can be worth a little extra plumbing to
get your search control Leaf to express the item structure for you. To do this make sure
your add Leaf implements the `AddingModelLeafInterface`. This forces you to implement the
`getItemAddedEvent` in your add Leaf.

The `ModelSearchOrAddControl` looks for this interface and if present can attach a handler to the
item added event. This event should be passed a Model and receive an item structure by return. 

```php
class AddContact extends Leaf implements AddingModelLeafInterface
{
    private $itemAddedEvent;

    public function __construct(string $name = null)
    {
        $this->itemAddedEvent = new Event();

        parent::__construct($name);
    }

    public function getItemAddedEvent(): Event
    {
        // Satisfy the interface...
        return $this->itemAddedEvent;
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

           // Raise the event to let the model search control create the item structure for you.
           // Pass it the model and return it's response.
           return $this->itemAddedEvent->raise($contact);
        });
    }
}
```

The view bridge of your add Leaf needs to pass this value on:

```javascript
rhubarb.vb.create('AddContactViewBridge', function() {
    return {
        attachEvents:function() {
            this.viewNode.querySelector('.js-add').addEventListener('click', function(event){    
                this.raiseServerEvent("addContact", function(item){
                    // Raise the event to let the search control know we've successfully added a new record.
                    // In this example `item` is returned by the PHP as outlined in the code sample above.
                    this.raiseClientEvent("ItemAdded", item);    
                }.bind(this));
            }.bind(this));
        }
    };
})
```

To allow users to back out of adding a new item you should raise the `CancelAdd` client event:

```javascript
rhubarb.vb.create('AddContactViewBridge', function() {
    return {
        attachEvents:function() {
            this.viewNode.querySelector('.js-cancel-add').addEventListener('click', function(event){
                // The `CancelAdd` event restores the UI to the way it should be.
                this.raiseClientEvent('CancelAdd');
                event.preventDefault();
                return false;
            }.bind(this));
        }
    };
})
```

### Demo

``` demo[examples/ModelSearchOrAddControlExample.php,ContactSearchWithAddControl.php,AddContact.php,AddContactView.php,AddContactViewBridge.js,ModelSearchOrAddControlExampleView.php]
```

### In-Situ style adding

For very small record types (for example single text boxes like a category) some interfaces call for a
pattern where when the user hit's add the search is
replaced with the adding interface, but unlike the example above there is no add or cancel button. Instead
when the user 'saves' the overall page, the page will do the smart thing - use the selected value if present
OR create a new item using the controls in the adding interface.

In our example above we could easily have left out the "Add Contact" and "Cancel" buttons to get the desired
appearance. However because our add interface is nested 'inside' the search control, the data will be bound
to a Leaf model not accessible to the page.

To side step this the recommended pattern is to pass the page's model (or a single property of it) by reference
to the add Leaf and change the binding source on the add Leaf to be this property. This way any data
posted back by the add interface will be placed onto the page's own model and the page can then be
responsible for creating the new record.

``` demo[examples/ModelSearchOrAddInSituExample.php,ContactSearchWithAddInSituControl.php,AddContactInSitu.php,AddContactInSituModel.php,AddContactInSituView.php,ModelSearchOrAddInSituExampleView.php,ModelSearchOrAddInSituExampleModel.php]
```