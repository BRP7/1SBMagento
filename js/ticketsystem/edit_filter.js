var j = jQuery.noConflict();
var customFilter = Class.create({
    container: null,
    form: null,
    initialize: function (redirectUrl, formKey) {
        this.container = $$('.popup-container')[0];
        console.log(this.container);
        this.redirectUrl = redirectUrl;
        this.formKey = formKey
        this.form = $$('.filter-form')[0];
        this.attachEvents();
    },

    attachEvents: function () {
        document.body.observe('click', function (event) {
            var element = event.findElement('.add-filter-button');
            if (element) {
                this.openPopup();
                event.stop();
                return;
            }
            element = event.findElement('.close-popup-button');
            if (element) {
                this.closePopup();
                event.stop();
                return;
            }

            element = event.findElement('.save-button');
            if (element) {
                this.saveFilter();
                event.stop();
                return;
            }

        }.bind(this));
    },


    openPopup: function () {
        var popup = this.container;
        popup.style.display = 'block';
        popup.style.position = 'absolute';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.background = '#fff';
        popup.style.padding = '20px';
        popup.style.border = '1px solid #ccc';
        popup.style.zIndex = 1000;

        var overlay = document.createElement('div');
        overlay.id = 'overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = 0;
        overlay.style.left = 0;
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.background = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = 999;
        document.body.appendChild(overlay);
    },

    closePopup: function () {
        $('overlay').remove();
        this.container.hide();
    },

    saveFilter: function () {
        var formData = this.form.serialize();
        console.log(this.redirectUrl);
        console.log({ formData });
        new Ajax.Request(this.redirectUrl, {
            method: 'post',
            parameters:
            {
                data: formData
            },
            onSuccess: function (response) {
                if (response.success) {
                    var label = customFilter.form.find('input[name="label"]').val();
                    customFilter.createFilterButton(label);
                    customFilter.closePopup();
                } else {
                    alert('Failed to save filter');
                }
            },
            onerror: function (error) {
                console.error('Error in AJAX request');
            }

        });
    },

    createFilterButton: function (label) {
        var container = $('.filter-buttons-container');
        var button = $('<button>', {
            text: label,
            class: 'filter-button'
        });
        container.append(button);
    }
});