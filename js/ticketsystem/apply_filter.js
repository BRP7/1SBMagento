var j = jQuery.noConflict();
var applyFilter = Class.create({
    initialize: function (redirectUrl, formKey) {
        this.redirectUrl = redirectUrl;
        this.formKey = formKey
    },
    addFilter: function (element) {

        new Ajax.Request(this.redirectUrl, {
            method: 'post',
            parameters:
            {
                buttonName: element.textContent,
                formKey: this.formKey
            },
            onSuccess: function (response) {
                var tableContainer = $$('.ticket-table-container')[0];
                if (tableContainer) {
                    tableContainer.update(response.responseText);
                } else {
                    console.error('ticket-table-container element not found.');
                }
            },
            onerror: function (error) {
                console.error('Error in AJAX request');
            }

        });
    }
})