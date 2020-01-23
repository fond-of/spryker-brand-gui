'use strict';

var SelectTableAPI = require('./select-company-table-api');

$(document).ready(function () {
    var availableCompaniesTable = new SelectTableAPI();
    var assignedCompaniesTable = new SelectTableAPI();

    availableCompaniesTable.init(
        '#available-company-table',
        '#companiesToBeAssigned',
        '.available-company-table-all-companies-checkbox',
        'a[href="#tab-content-assignment_company"]',
        '#brandAggregate_companyIdsToBeAssigned'
    );

    assignedCompaniesTable.init(
        '#assigned-company-table',
        '#companiesToBeDeassigned',
        '.assigned-company-table-all-companies-checkbox',
        'a[href="#tab-content-deassignment_company"]',
        '#brandAggregate_companyIdsToBeDeAssigned'
    );
});

module.exports = SelectTableAPI;