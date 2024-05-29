varienGrid.prototype.saveCustomerReport = function () {
    reportType = getReportType();
    var filters = [];
    $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select').each(function (element) {
        if (element.value) {
            filters.push({ name: element.name, value: element.value });
        }
    });
    var saveAjax = new SaveAjax("http://127.0.0.1/1SBMagento/index.php/admin/custom/savereport/key/" + FORM_KEY);
    saveAjax.send({ filters: Object.toJSON(filters), reportType: reportType }, function (responseData) {
        alert(responseData.message);
    });
}
varienGrid.prototype.loadFilters = function () {
    var saveAjax = new SaveAjax("http://127.0.0.1/1SBMagento/index.php/admin/custom/loadreport/key/" + FORM_KEY);
    saveAjax.send({ reportType: getReportType() }, function (responseData) {
        if (responseData.success) {
            applyStoredFilters(responseData.filters);
        } else {
            console.error('Error loading filters: ' + responseData.message);
        }
    });
}
var SaveAjax = Class.create({
    initialize: function (saveReportUrl) {
        this.saveReportUrl = saveReportUrl;
    },
    send: function (data, callback) {
        new Ajax.Request(this.saveReportUrl, {
            method: 'post',
            parameters: data,
            onSuccess: function (response) {
                var responseData = JSON.parse(response.responseText);
                console.log(responseData);
                if (typeof callback === 'function') {
                    callback(responseData);
                }
            },
            onFailure: function () {
                console.log('Error saving report.');
            }
        });
    }
});
function getReportType() {
    var url = window.location.href;
    if (url.indexOf('customer') !== -1) {
        return 'customer';
    } else if (url.indexOf('product') !== -1) {
        return 'product';
    } else if (url.indexOf('custom') !== -1) {
        return 'custom';
    }
    return 'unknown';
}
function applyStoredFilters(storedFilters) {
    if (typeof storedFilters === 'string') {
        storedFilters = JSON.parse(storedFilters);
    }
    storedFilters.forEach(function (filter) {
        var element = $$('input[name="' + filter.name + '"], select[name="' + filter.name + '"]').first();
        if (element) {
            element.value = filter.value;
        }
    });
    // console.log(gridObject());
    gridObject().doFilter(); // This should not trigger loadFilters again due to the flag
}

document.observe('dom:loaded', function () {
    // console.log("DOM fully loaded and parsed");
    // console.log(gridObject());
    gridObject().loadFilters();
});

function gridObject() {
    var type = getReportType();
    console.log(type);
    switch (type) {
        case 'product':
            return productGridJsObject;
        case 'customer':
            return customerGridJsObject;
        case 'custom':
            return customerGridJsObject;
        default:
            return null;
    }
}