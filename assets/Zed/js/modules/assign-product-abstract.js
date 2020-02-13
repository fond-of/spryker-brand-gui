'use strict';

var SelectTableAPI = require('./select-product-abstract-table-api');

$(document).ready(function () {
    var availableProductAbstractsTable = new SelectTableAPI();
    var assignedProductAbstractsTable = new SelectTableAPI();

    availableProductAbstractsTable.init(
        '#available-product-abstract-table',
        '#productAbstractsToBeAssigned',
        '.available-product-abstract-table-all-product-abstracts-checkbox',
        'a[href="#tab-content-assignment_product_abstract"]',
        '#brandAggregate_productAbstractIdsToBeAssigned'
    );

    assignedProductAbstractsTable.init(
        '#assigned-product-abstract-table',
        '#productAbstractsToBeDeassigned',
        '.assigned-product-abstract-table-all-product-abstracts-checkbox',
        'a[href="#tab-content-deassignment_product_abstract"]',
        '#brandAggregate_productAbstractIdsToBeDeAssigned'
    );
});

module.exports = SelectTableAPI;