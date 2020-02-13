'use strict';

var SelectProductAbstractTableApi = function() {
    this.selectedProductAbstractsData = [];
    this.removeBtnSelector = '.js-remove-item';
    this.removeBtnTemplate = '<a href="#" class="js-remove-item btn-xs">Remove</a>';
    this.counterSelector = '.js-counter';
    this.counterTemplate = '<span class="js-counter"></span>';
    this.initialDataLoaded = false;

    /**
     * Init all table adding functionality.
     * @param {string} productAbstractTable - Current table with abstract products.
     * @param {string} selectedProductAbstractsTable - Table where should product abstract be added.
     * @param {string} checkboxSelector - Checkbox selector.
     * @param {string} counterLabelSelector - Tabs label where will be added count of select abstract products.
     * @param {string} inputWithSelectedProductAbstracts - In this input will putted all selected product abstract ids.
     */
    this.init = function(productAbstractTable, selectedProductAbstractsTable, checkboxSelector, counterLabelSelector, inputWithSelectedProductAbstracts) {
        this.$productAbstractTable = $(productAbstractTable);
        this.$selectedProductAbstractsTable = $(selectedProductAbstractsTable);
        this.$counterLabel = $(counterLabelSelector);
        this.$inputWithSelectedProductAbstracts = $(inputWithSelectedProductAbstracts);
        this.checkboxSelector = checkboxSelector;
        this.counterSelector = counterLabelSelector + ' ' + this.counterSelector;

        this.drawProductAbstractsTable();
        this.addRemoveButtonClickHandler();
        this.addCounterToLabel();
    };

    this.selectProductAbstractsOnLoad = function(initialSelectedProductAbstractsData) {
        if (this.initialDataLoaded) {
            return;
        }

        var data = initialSelectedProductAbstractsData.replace(/&quot;/g, '"').replace(/,/g, '');
        var parsedData = JSON.parse(data);

        for (var i = 0; i < parsedData.length; i++) {
            parsedData[i].push('');
            this.addRow(parsedData[i]);
        }

        this.initialDataLoaded = true;
    };

    /**
     * Draw method of DataTable. Fires every time table rerender.
     */
    this.drawProductAbstractsTable = function() {
        var self = this,
            productAbstractTableData = self.$productAbstractTable.DataTable();

        productAbstractTableData.on('draw', function(event, settings) {
            self.updateCheckboxes();
            self.mapEventsToCheckboxes(productAbstractTableData, $(self.checkboxSelector));

            if (self.$inputWithSelectedProductAbstracts && initialSelectedProductAbstractsData) {
                var initialSelectedProductAbstractsData = self.$inputWithSelectedProductAbstracts.val();

                self.selectProductAbstractsOnLoad(initialSelectedProductAbstractsData);
                self.$inputWithSelectedProductAbstracts.val('');
            }
        });
    };

    /**
     * Add change event for all checkboxes checkbox. Fires every time, when product abstract table redraws.
     * @param {object} productAbstractTableData - DataTable options ( get by $(element).DataTable() ).
     * @param {checkboxes} checkboxes - Collection of all checkboxes in product abstract Table.
     */
    this.mapEventsToCheckboxes = function(productAbstractTableData, checkboxes) {
        var self = this;

        checkboxes.off('change');
        checkboxes.on('change', function () {
            var rowIndex = checkboxes.index($(this)),
                rowData = productAbstractTableData.data()[rowIndex],
                id = rowData[0];

            if ($(this).is(':checked')) {
                return self.addRow(rowData);
            }

            return self.removeRow(id);
        });
    };

    /**
     * Check for selected abstract products in product abstract table.
     */
    this.updateCheckboxes = function() {
        var productAbstractTable = this.$productAbstractTable.DataTable(),
            productAbstractTableData = productAbstractTable.data();

        for (var i = 0; i < productAbstractTableData.length; i++) {
            var productAbstractItemData = productAbstractTableData[i],
                productAbstractItemId = productAbstractItemData[0],
                checkBox = $(productAbstractTable.row(i).node()).find('[type="checkbox"]');

            checkBox.prop('checked', false);

            this.findSelectedProductAbstractsInTable(checkBox, productAbstractItemId);
        }
    };

    /**
     * Check for selected abstract products in product abstract table.
     * @param {object} checkBox - Jquery object with checkbox.
     * @param {number} productAbstractItemId - Id if product abstract row.
     */
    this.findSelectedProductAbstractsInTable = function(checkBox,productAbstractItemId) {
        var itemEqualId = function(item) {
            return item[0] === productAbstractItemId;
        };

        if (this.selectedProductAbstractsData.some(itemEqualId)) {
            checkBox.prop('checked', true);
        }
    };

    /**
     * Update counter.
     */
    this.updateCounter = function() {
        var counterText = '';

        if (this.selectedProductAbstractsData.length) {
            counterText = ' ('+this.selectedProductAbstractsData.length+')';
        }

        $(this.counterSelector).html(counterText);
    };

    /**
     * Update selected abstract products input value.
     * @param {number} id - Selected abstract product id.
     */
    this.updateSelectedProductAbstractsInputValue = function() {
        var inputValue = this.selectedProductAbstractsData.reduce(function(concat, current, index) {
            return index ? concat + ',' + current[0] : current[0];
        }, '');

        this.$inputWithSelectedProductAbstracts.val(inputValue);
    };

    /**
     * Add selected product abstract to array with all selected items.
     * @param {array} rowData - Array of all data selected product abstract.
     */
    this.addRow = function(rowData) {
        var productAbstractItem = rowData.slice();
        productAbstractItem[rowData.length - 1] = this.removeBtnTemplate.replace('#', productAbstractItem[0]);
        this.selectedProductAbstractsData.push(productAbstractItem);
        this.renderSelectedItemsTable(productAbstractItem);
    };

    /**
     * Remove row from array with all selected items.
     * @param {number} id - ProductAbstracts id which should be deleted.
     */
    this.removeRow = function(id) {
        var self = this;

        this.selectedProductAbstractsData.every(function(elem,index) {
            if (elem[0] !== Number(id)) {
                return true;
            }

            self.selectedProductAbstractsData.splice(index,1);
            return false;

        });
        self.renderSelectedItemsTable();
    };

    /**
     * Add event for remove button to remove row from array with all selected items.
     */
    this.addRemoveButtonClickHandler = function() {
        var self = this,
            selectedTable = this.$selectedProductAbstractsTable;

        selectedTable.on('click', this.removeBtnSelector, function (e) {
            e.preventDefault();

            var id = $(e.target).attr('href');

            self.removeRow(id);
            self.updateCheckboxes();
        });
    };

    /**
     * Add counter template on init.
     */
    this.addCounterToLabel = function() {
        this.$counterLabel.append(this.counterTemplate);
    };

    /**
     * Redraw table with selected items.
     */
    this.renderSelectedItemsTable = function() {
        this.$selectedProductAbstractsTable
            .DataTable()
            .clear()
            .rows
            .add(this.selectedProductAbstractsData).draw();

        this.updateCounter();
        this.updateSelectedProductAbstractsInputValue();
        this.updateCheckboxes();
    };
}

module.exports = SelectProductAbstractTableApi;