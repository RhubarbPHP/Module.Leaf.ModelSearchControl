rhubarb.vb.create('AddContactViewBridge', function() {
    return {
        attachEvents:function() {
            this.findChildViewBridge("AddContact").attachClientEventHandler("ButtonPressCompleted", function(item){
                // Raise the event to let the search control know we've successfully added a new record. `item`
                // has been returned by the PHP event handler in AddContactView.php - it is a selection item
                // ready for the search control to 'select'
                this.raiseClientEvent("ItemAdded", item);
            }.bind(this));

            this.viewNode.querySelector('.js-cancel-add').addEventListener('click', function(event){
                // The `CancelAdd` event restores the UI to the way it should be.
                this.raiseClientEvent('CancelAdd');
                event.preventDefault();
                return false;
            }.bind(this));
        }
    };
})