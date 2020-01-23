'use strict';

var SelectCompanyTableApi = function() {
    this.selectedCompaniesData = [];
    this.removeBtnSelector = '.js-remove-item';
    this.removeBtnTemplate = '<a href="#" class="js-remove-item btn-xs">Remove</a>';
    this.counterSelector = '.js-counter';
    this.counterTemplate = '<span class="js-counter"></span>';
    this.initialDataLoaded = false;

    /**
     * Init all table adding functionality.
     * @param {string} companyTable - Current table with companies.
     * @param {string} selectedCompaniesTable - Table where should company be added.
     * @param {string} checkboxSelector - Checkbox selector.
     * @param {string} counterLabelSelector - Tabs label where will be added count of select companies.
     * @param {string} inputWithSelectedCompanies - In this input will putted all selected company ids.
     */
    this.init = function(companyTable, selectedCompaniesTable, checkboxSelector, counterLabelSelector, inputWithSelectedCompanies) {
        this.$companyTable = $(companyTable);
        this.$selectedCompaniesTable = $(selectedCompaniesTable);
        this.$counterLabel = $(counterLabelSelector);
        this.$inputWithSelectedCompanies = $(inputWithSelectedCompanies);
        this.checkboxSelector = checkboxSelector;
        this.counterSelector = counterLabelSelector + ' ' + this.counterSelector;

        this.drawCompaniesTable();
        this.addRemoveButtonClickHandler();
        this.addCounterToLabel();
    };

    this.selectCompaniesOnLoad = function(initialSelectedCompaniesData) {
        if (this.initialDataLoaded) {
            return;
        }

        var data = initialSelectedCompaniesData.replace(/&quot;/g, '"').replace(/,/g, '');
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
    this.drawCompaniesTable = function() {
        var self = this,
            companyTableData = self.$companyTable.DataTable();

        companyTableData.on('draw', function(event, settings) {
            self.updateCheckboxes();
            self.mapEventsToCheckboxes(companyTableData, $(self.checkboxSelector));

            if (self.$inputWithSelectedCompanies && initialSelectedCompaniesData) {
                var initialSelectedCompaniesData = self.$inputWithSelectedCompanies.val();

                self.selectCompaniesOnLoad(initialSelectedCompaniesData);
                self.$inputWithSelectedCompanies.val('');
            }
        });
    };

    /**
     * Add change event for all checkboxes checkbox. Fires every time, when company table redraws.
     * @param {object} companyTableData - DataTable options ( get by $(element).DataTable() ).
     * @param {checkboxes} checkboxes - Collection of all checkboxes in Company Table.
     */
    this.mapEventsToCheckboxes = function(companyTableData, checkboxes) {
        var self = this;

        checkboxes.off('change');
        checkboxes.on('change', function () {
            var rowIndex = checkboxes.index($(this)),
                rowData = companyTableData.data()[rowIndex],
                id = rowData[0];

            if ($(this).is(':checked')) {
                return self.addRow(rowData);
            }

            return self.removeRow(id);
        });
    };

    /**
     * Check for selected companies in company table.
     */
    this.updateCheckboxes = function() {
        var companyTable = this.$companyTable.DataTable(),
            companyTableData = companyTable.data();

        for (var i = 0; i < companyTableData.length; i++) {
            var companyItemData = companyTableData[i],
                companyItemId = companyItemData[0],
                checkBox = $(companyTable.row(i).node()).find('[type="checkbox"]');

            checkBox.prop('checked', false);

            this.findSelectedCompaniesInTable(checkBox, companyItemId);
        }
    };

    /**
     * Check for selected companies in company table.
     * @param {object} checkBox - Jquery object with checkbox.
     * @param {number} companyItemId - Id if company row.
     */
    this.findSelectedCompaniesInTable = function(checkBox,companyItemId) {
        var itemEqualId = function(item) {
            return item[0] === companyItemId;
        };

        if (this.selectedCompaniesData.some(itemEqualId)) {
            checkBox.prop('checked', true);
        }
    };

    /**
     * Update counter.
     */
    this.updateCounter = function() {
        var counterText = '';

        if (this.selectedCompaniesData.length) {
            counterText = ' ('+this.selectedCompaniesData.length+')';
        }

        $(this.counterSelector).html(counterText);
    };

    /**
     * Update selected companies input value.
     * @param {number} id - Selected company id.
     */
    this.updateSelectedCompaniesInputValue = function() {
        var inputValue = this.selectedCompaniesData.reduce(function(concat, current, index) {
            return index ? concat + ',' + current[0] : current[0];
        }, '');

        this.$inputWithSelectedCompanies.val(inputValue);
    };

    /**
     * Add selected company to array with all selected items.
     * @param {array} rowData - Array of all data selected company.
     */
    this.addRow = function(rowData) {
        var companyItem = rowData.slice();
        companyItem[rowData.length - 1] = this.removeBtnTemplate.replace('#', companyItem[0]);
        this.selectedCompaniesData.push(companyItem);
        this.renderSelectedItemsTable(companyItem);
    };

    /**
     * Remove row from array with all selected items.
     * @param {number} id - Companies id which should be deleted.
     */
    this.removeRow = function(id) {
        var self = this;

        this.selectedCompaniesData.every(function(elem,index) {
            if (elem[0] !== Number(id)) {
                return true;
            }

            self.selectedCompaniesData.splice(index,1);
            return false;

        });
        self.renderSelectedItemsTable();
    };

    /**
     * Add event for remove button to remove row from array with all selected items.
     */
    this.addRemoveButtonClickHandler = function() {
        var self = this,
            selectedTable = this.$selectedCompaniesTable;

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
        this.$selectedCompaniesTable
            .DataTable()
            .clear()
            .rows
            .add(this.selectedCompaniesData).draw();

        this.updateCounter();
        this.updateSelectedCompaniesInputValue();
        this.updateCheckboxes();
    };
}

module.exports = SelectCompanyTableApi;