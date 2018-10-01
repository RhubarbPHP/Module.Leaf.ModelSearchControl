Model Selection Controls
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

``` demo[examples/ModelSearchControlExample.php,ContactSearchControl.php,ModelSearchControlExampleView.php,ModelSearchControlExampleViewBridge.js]
```