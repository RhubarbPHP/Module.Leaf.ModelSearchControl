rhubarb.vb.create('ModelSearchOrAddControlViewBridge',function(parent){
    return {
        attachEvents: function () {
            parent.attachEvents.call(this);

            if (!this.addButton) {
                this.addButton = document.createElement('input');
                this.addButton.type = 'button';
                this.addButton.value = 'Add';

                this.buttonsContainer.appendChild(this.addButton);
                this.addLeaf = this.findChildViewBridge("Add");

                var self = this;

                this.addLeaf.attachClientEventHandler("ItemAdded", function (item) {
                    self.setSelectedItems([item]);
                });

                this.addLeaf.attachClientEventHandler("CancelAdd", function(){
                    self.addLeaf.reset();
                    self._state = 'unselected';
                    self.updateUiState();
                });

                this.addButton.addEventListener('click',function(){
                    self.addLeaf.reset();
                    self._state = 'adding';
                    self.updateUiState();
                });
            }
        },
        updateUiState: function () {
            parent.updateUiState.call(this);

            this.addButton.style.display = 'none';

            switch (this._state) {
                case "adding":
                    this.addLeaf.show();
                    break;
                case "unselected":
                    this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "searching":
                    this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "searched":
                    this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "selected":
                    this.addLeaf.hide();
                    break;
            }

        }
    }
}, rhubarb.viewBridgeClasses.SearchControl);