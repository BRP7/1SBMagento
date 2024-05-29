varientGrid.prototype.saveCustomerReport = function () {
    var reportType = getReportType();
    var filters = [];
    $$('#' + this.containerId + '.filter input ', '#' + this.containerId + '.filter select').each(function (element) {
        if (element.value) {
            filters.puch({ name: element.name, value: element.value });
        }
    });
    var saveAjax=new SaveAjax("http://127.0.0.1/1SBMagento/index.php/admin/custom/savereport/key/" + FORM_KEY);
    saveAjax.send({filters:Object.toJSON(filters),reportType:report},function (responseData){
        alert(responseData.message);
    });
}
varienGrid.prototype.loadFilters = function () {
    var saveAjax = new SaveAjax("http://127.0.0.1/1SBMagento/index.php/admin/custom/loadreport/key/" + FORM_KEY);
    saveAjax.send({ reportType: getReportType() }, function (responseData) {
        if (responseData.success) {
            applyStoredFilters(JSON.parse(responseData.filters));
        } else {
            console.error('Error loading filters.');
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
    gridObject().doFilter();
}
function gridObject() {
    var type=getReportType();
    switch (type) {
        case 'product':
            return productGridJsObject;
        case 'customer':
            return customerGridJsObject;
        default:
            return null;
    }
}
document.observe('dom:loaded', function () { 
    gridObject().loadFilters();
});