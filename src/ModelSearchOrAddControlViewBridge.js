rhubarb.vb.create('ModelSearchOrAddControlViewBridge',function(parent){
    return {
        attachEvents: function () {
            parent.attachEvents.call(this);

            if (!this.addButton) {

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

                this.createAddButton();
            }
        },
        updateUiState: function () {
            parent.updateUiState.call(this);

            // this.addButton.style.display = 'none';

            debugger;
            switch (this._state) {
                case "adding":
                    this.addLeaf.show();
                    break;
                case "unselected":
                    // this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "searching":
                    // this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "searched":
                    // this.addButton.style.display = 'block';
                    this.addLeaf.hide();
                    break;
                case "selected":
                    this.addLeaf.hide();
                    break;
            }

        },

        createDom:function (){
            this.interfaceContainer = document.querySelector('.c-super-search-container');
            this.interfaceContainer.classList.add('search-control');
            this.phraseBox = document.createElement("input");
            this.phraseBox.classList.add("phrase-box");
            this.phraseBox.setAttribute("type", "text");

            this.selectedLabel = document.createElement("span");
            this.clearButton = document.createElement("input");
            this.clearButton.setAttribute("type", "button");
            this.clearButton.value = 'Clear';

            this.resultsList = document.createElement("div");

            this.resultsTable = document.createElement("div");
            this.resultsTable.classList.add("results-list");
            this.resultsTable.appendChild(this.resultsList);

            this.resultsContainer = document.createElement("div");
            this.resultsContainer.classList.add("results");
            this.resultsContainer.classList.add("drop-down");
            this.resultsContainer.classList.add('c-super-search');
            this.resultsContainer.style.zIndex = 1000;

            this.buttonsContainer = document.createElement("div");
            this.buttonsContainer.classList.add("button-container");
            this.buttonsContainer.classList.add("inline");

            this.resultsContainer.appendChild(this.resultsTable);
            this.buttonsContainer.appendChild(this.clearButton);

            this.resultsContainer.style.display = "none";

            this.interfaceContainer.appendChild(this.phraseBox);
            this.interfaceContainer.appendChild(this.selectedLabel);
            this.interfaceContainer.appendChild(this.buttonsContainer);
            this.interfaceContainer.appendChild(this.resultsContainer);
            this.onCreateDom();
        },

        createResultItemDom:function(item){
            var itemDiv = document.createElement('div');
            itemDiv.classList.add('c-super-search__item');

            var iconDiv = document.createElement('div');
            iconDiv.classList.add('c-super-search__secondary');
            itemDiv.appendChild(iconDiv);

            var icon = document.createElement('span');
            icon.classList.add('c-icon');
            icon.classList.add('c-icon--cow');
            icon.classList.add('u-gamma');
            iconDiv.appendChild(icon);

            var resultDiv = document.createElement('div');
            resultDiv.classList.add('c-super-search__primary');
            itemDiv.appendChild(resultDiv);

            var resultName = document.createElement('p');
            var splitResult = item.label.split(':',2);
            resultName.classList.add('u-bold');
            resultName.textContent = splitResult[0];

            var resultAddress = document.createElement('p');
            resultAddress.classList.add('u-lighten');
            resultAddress.textContent = splitResult[1];
            resultDiv.appendChild(resultName);
            resultDiv.appendChild(resultAddress);

            itemDiv.value = item.value;
            itemDiv.data = item;

            var self = this;

            // This would be more efficient as an event on the outer list, however that would mean knowing the correct
            // child selector which might change and also fragments the code a little.
            itemDiv.addEventListener('click', function () {
                self.itemDomSelected(this);
            });

            return itemDiv;
        },

        attachSearchInterfaceToDom:function(){

        },

        createAddButton:function(){

            var textContainer = document.createElement('div');
            textContainer.classList.add('c-super-search__primary');

            var addButtonParagraph = document.createElement('p');
            addButtonParagraph.classList.add('u-bold');
            addButtonParagraph.textContent = this.getAddButtonText();
            textContainer.appendChild(addButtonParagraph);

            var iconContainer = document.createElement('div');
            iconContainer.classList.add('c-super-search__secondary');

            var icon = document.createElement('span');
            icon.classList.add('c-icon');
            icon.classList.add('c-icon--add_circle');
            icon.classList.add('u-primary');
            icon.classList.add('u-gamma');
            iconContainer.appendChild(icon);

            this.addButton = document.createElement('div');
            this.addButton.classList.add('c-super-search__item');
            this.addButton.classList.add('u-fill-light');

            this.addButton.appendChild(iconContainer);
            this.addButton.appendChild(textContainer);
            this.resultsList.prepend(this.addButton);

            var self = this;
            this.addButton.addEventListener('click',function(){
                self.addLeaf.reset();
                self._state = 'adding';
                self.updateUiState();
            });
        },

        getAddButtonText:function(){
            return 'Add New';
        },

        onSearchResultsReceived:function (items) {
            parent.onSearchResultsReceived.call(this,items);
            this.createAddButton();
        },

        createItemLabelDom:function(labelString){
            return '<div class = "c-super-search__item"><p>'+ labelString +'</p></div>'
        }
    }
}, rhubarb.viewBridgeClasses.SearchControl);