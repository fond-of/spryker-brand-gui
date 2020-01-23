'use strict';

var SelectCustomerTableApi = function() {
    this.selectedCustomersData = [];
    this.removeBtnSelector = '.js-remove-item';
    this.removeBtnTemplate = '<a href="#" class="js-remove-item btn-xs">Remove</a>';
    this.counterSelector = '.js-counter';
    this.counterTemplate = '<span class="js-counter"></span>';
    this.initialDataLoaded = false;

    /**
     * Init all table adding functionality.
     * @param {string} customerTable - Current table with customers.
     * @param {string} selectedCustomersTable - Table where should customer be added.
     * @param {string} checkboxSelector - Checkbox selector.
     * @param {string} counterLabelSelector - Tabs label where will be added count of select customers.
     * @param {string} inputWithSelectedCustomers - In this input will putted all selected customer ids.
     */
    this.init = function(customerTable, selectedCustomersTable, checkboxSelector, counterLabelSelector, inputWithSelectedCustomers) {
        this.$customerTable = $(customerTable);
        this.$selectedCustomersTable = $(selectedCustomersTable);
        this.$counterLabel = $(counterLabelSelector);
        this.$inputWithSelectedCustomers = $(inputWithSelectedCustomers);
        this.checkboxSelector = checkboxSelector;
        this.counterSelector = counterLabelSelector + ' ' + this.counterSelector;

        this.drawCustomersTable();
        this.addRemoveButtonClickHandler();
        this.addCounterToLabel();
    };

    this.selectCustomersOnLoad = function(initialSelectedCustomersData) {
        if (this.initialDataLoaded) {
            return;
        }

        var data = initialSelectedCustomersData.replace(/&quot;/g, '"').replace(/,/g, '');
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
    this.drawCustomersTable = function() {
        var self = this,
            customerTableData = self.$customerTable.DataTable();

        customerTableData.on('draw', function(event, settings) {
            self.updateCheckboxes();
            self.mapEventsToCheckboxes(customerTableData, $(self.checkboxSelector));

            if (self.$inputWithSelectedCustomers && initialSelectedCustomersData) {
                var initialSelectedCustomersData = self.$inputWithSelectedCustomers.val();

                self.selectCustomersOnLoad(initialSelectedCustomersData);
                self.$inputWithSelectedCustomers.val('');
            }
        });
    };

    /**
     * Add change event for all checkboxes checkbox. Fires every time, when customer table redraws.
     * @param {object} customerTableData - DataTable options ( get by $(element).DataTable() ).
     * @param {checkboxes} checkboxes - Collection of all checkboxes in Customer Table.
     */
    this.mapEventsToCheckboxes = function(customerTableData, checkboxes) {
        var self = this;

        checkboxes.off('change');
        checkboxes.on('change', function () {
            var rowIndex = checkboxes.index($(this)),
                rowData = customerTableData.data()[rowIndex],
                id = rowData[0];

            if ($(this).is(':checked')) {
                return self.addRow(rowData);
            }

            return self.removeRow(id);
        });
    };

    /**
     * Check for selected customers in customer table.
     */
    this.updateCheckboxes = function() {
        var customerTable = this.$customerTable.DataTable(),
            customerTableData = customerTable.data();

        for (var i = 0; i < customerTableData.length; i++) {
            var customerItemData = customerTableData[i],
                customerItemId = customerItemData[0],
                checkBox = $(customerTable.row(i).node()).find('[type="checkbox"]');

            checkBox.prop('checked', false);

            this.findSelectedCustomersInTable(checkBox, customerItemId);
        }
    };

    /**
     * Check for selected customers in customer table.
     * @param {object} checkBox - Jquery object with checkbox.
     * @param {number} customerItemId - Id if customer row.
     */
    this.findSelectedCustomersInTable = function(checkBox,customerItemId) {
        var itemEqualId = function(item) {
            return item[0] === customerItemId;
        };

        if (this.selectedCustomersData.some(itemEqualId)) {
            checkBox.prop('checked', true);
        }
    };

    /**
     * Update counter.
     */
    this.updateCounter = function() {
        var counterText = '';

        if (this.selectedCustomersData.length) {
            counterText = ' ('+this.selectedCustomersData.length+')';
        }

        $(this.counterSelector).html(counterText);
    };

    /**
     * Update selected customers input value.
     * @param {number} id - Selected customer id.
     */
    this.updateSelectedCustomersInputValue = function() {
        var inputValue = this.selectedCustomersData.reduce(function(concat, current, index) {
            return index ? concat + ',' + current[0] : current[0];
        }, '');

        this.$inputWithSelectedCustomers.val(inputValue);
    };

    /**
     * Add selected customer to array with all selected items.
     * @param {array} rowData - Array of all data selected customer.
     */
    this.addRow = function(rowData) {
        var customerItem = rowData.slice();
        customerItem[rowData.length - 1] = this.removeBtnTemplate.replace('#', customerItem[0]);
        this.selectedCustomersData.push(customerItem);
        this.renderSelectedItemsTable(customerItem);
    };

    /**
     * Remove row from array with all selected items.
     * @param {number} id - Customers id which should be deleted.
     */
    this.removeRow = function(id) {
        var self = this;

        this.selectedCustomersData.every(function(elem,index) {
            if (elem[0] !== Number(id)) {
                return true;
            }

            self.selectedCustomersData.splice(index,1);
            return false;

        });
        self.renderSelectedItemsTable();
    };

    /**
     * Add event for remove button to remove row from array with all selected items.
     */
    this.addRemoveButtonClickHandler = function() {
        var self = this,
            selectedTable = this.$selectedCustomersTable;

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
        this.$selectedCustomersTable
            .DataTable()
            .clear()
            .rows
            .add(this.selectedCustomersData).draw();

        this.updateCounter();
        this.updateSelectedCustomersInputValue();
        this.updateCheckboxes();
    };
}

module.exports = SelectCustomerTableApi;
