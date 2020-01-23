'use strict';

var SelectTableAPI = require('./select-customer-table-api');

$(document).ready(function () {
    var availableCustomersTable = new SelectTableAPI();
    var assignedCustomersTable = new SelectTableAPI();

    availableCustomersTable.init(
        '#available-customer-table',
        '#customersToBeAssigned',
        '.available-customer-table-all-customers-checkbox',
        'a[href="#tab-content-assignment_customer"]',
        '#brandAggregate_customerIdsToBeAssigned'
    );

    assignedCustomersTable.init(
        '#assigned-customer-table',
        '#customersToBeDeassigned',
        '.assigned-customer-table-all-customers-checkbox',
        'a[href="#tab-content-deassignment_customer"]',
        '#brandAggregate_customerIdsToBeDeAssigned'
    );
});

module.exports = SelectTableAPI;