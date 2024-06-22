var j = jQuery.noConflict();
var TicketEditor = Class.create({
    initialize: function (ticketId, redirectUrl, formKey, users, status) {
        this.ticketId = ticketId;
        this.redirectUrl = redirectUrl;
        this.formKey = formKey;
        this.users = users
        this.status = status
        this.editableElements = $$('.editable');
        this.attachEvents();
    },
    attachEvents: function () {
        this.editableElements.each(function (element) {
            element.observe('click', this.makeEditable.bind(this));
        }, this);
    },
    makeEditable: function (event) {
        event.stop();
        var element = event.findElement('.editable');
        var field = element.dataset.field;
        var originalContent = element.innerHTML;
        element.hide();
        var inputElement;
        var uniqueId = 'edit-' + field + '-' + this.ticketId;

        if (field === 'description') {
            inputElement = new Element('textarea', { 'class': 'edit-input', id: uniqueId }).update(element.innerHTML.trim());
            element.insert({ after: inputElement });
            CKEDITOR.replace(uniqueId);

            var saveButton = new Element('button', { 'class': 'save-button' }).update('Save');
            inputElement.insert({ after: saveButton });
            saveButton.observe('click', this.saveField.bind(this, element, inputElement, field, originalContent));
        } else if (field === 'assign_by' || field === 'assign_to' || field === 'status_id') {
            inputElement = new Element('select', { 'class': 'edit-input' });
            if (field === 'status_id' && this.status && typeof this.status === 'object') {
                options = Object.keys(this.status).map(function (key) {
                    return { value: key, text: this.status[key] };
                }, this);
            } else if ((field === 'assign_by' || field === 'assign_to') && this.users && typeof this.users === 'object') {
                options = Object.keys(this.users).map(function (key) {
                    return { value: key, text: this.users[key] };
                }, this);
            }
            options.forEach(function (option) {
                var optionElement = new Element('option', { value: option.value }).update(option.text);
                if (field === 'status') {
                    if (option.text.trim() == element.querySelectorAll('span')[1].textContent) {
                        optionElement.setAttribute('selected', 'selected');
                    }
                }
                else {
                    if (option.text.trim() == originalContent.trim()) {
                        optionElement.setAttribute('selected', 'selected');
                    }
                }
                inputElement.insert(optionElement);
            });
            element.insert({ after: inputElement });
        } else {
            inputElement = new Element('input', { type: 'text', 'class': 'edit-input', value: element.innerHTML.trim() });
            element.insert({ after: inputElement });
        }
        var cancelButton = new Element('button', { 'class': 'cancel-button' }).update('Cancel');
        inputElement.insert({ after: cancelButton });
        inputElement.observe('change', this.saveField.bind(this, element, inputElement, field, originalContent));
        cancelButton.observe('click', this.cancelEdit.bind(this, element, inputElement, cancelButton));
    },
    saveField: function (element, inputElement, field, originalContent) {
        var newValue;
        var uniqueId = 'edit-' + field + '-' + this.ticketId;
        if (field === 'description' && CKEDITOR.instances[uniqueId]) {
            newValue = CKEDITOR.instances[uniqueId].getData();
            CKEDITOR.instances[uniqueId].destroy();
        } else {
            newValue = inputElement.value;
        }

        var ticketId = this.ticketId;
        new Ajax.Request(this.redirectUrl, {
            method: 'post',
            parameters: {
                ticket_id: ticketId,
                field: field,
                value: newValue,
                form_key: this.formKey
            },
            onSuccess: function (response) {
                var json = response.responseText.evalJSON();
                if (json.success) {
                    if (field === 'assign_by' || field === 'assign_to' || field === 'status_id') {
                        var displayText = '';
                        if (field === 'status_id') {
                            displayText = this.status[newValue] || newValue;
                        } else {
                            displayText = this.users[newValue] || newValue;
                        }
                        element.innerHTML = displayText;
                    } else {
                        element.innerHTML = json.newValue;
                    }
                    element.show();
                    inputElement.remove();
                    if (element.next('.cancel-button')) {
                        element.next('.cancel-button').remove();
                    }
                    if (element.next('.save-button')) {
                        element.next('.save-button').remove();
                    }
                } else {
                    alert('Failed to update the field.');
                    element.innerHTML = originalContent;
                    element.show();
                }
            }.bind(this)
        });
    },
    cancelEdit: function (element, inputElement, cancelButton) {
        var uniqueId = 'edit-' + element.dataset.field + '-' + this.ticketId;
        if (CKEDITOR.instances[uniqueId]) {
            CKEDITOR.instances[uniqueId].destroy();
        }
        element.show();
        inputElement.remove();
        cancelButton.remove();
    }
});
