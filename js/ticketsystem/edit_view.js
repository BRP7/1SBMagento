var TicketEditor = Class.create({
    initialize: function (ticketId, redirectUrl, formKey,userArray,statusArray) {
        this.ticketId = ticketId
        this.redirectUrl = redirectUrl
        this.formKey = formKey
        this.userArray = userArray
        this.statusArray = statusArray
        this.editableElements = $$('.editable');
        this.attachEvents();
    },
    attachEvents: function () {
        this.editableElements.each(function (element) {
            element.observe('click', this.makeElementEditable.bind(this));
        }, this);
    },
    makeElementEditable: function (event) {
        var element = event.element();
        var field = element.dataset.field;
        console.log(this.statusArray);
        var originalContent = element.innerHTML;
        element.hide();
        // console.log(element);
        var inputElement;
        if (field === 'description') {
            inputElement = new Element('textarea', { 'class': 'edit-input' }).update(element.innerHTML.trim());
        } else if (field === 'assign_by' || field === 'assign_to' || field === 'status') {
            inputElement = new Element('select', { 'class': 'edit-input' });
            var options = {
                assign_by: ['User 1', 'User 2'],
                assign_to: ['User 1', 'User 2'],
                status: ['Pending', 'In Progress', 'Resolved']
            };
            options[field].each(function (option) {
                inputElement.insert(new Element('option', { value: option }).update(option));
            });
        } else {
            inputElement = new Element('input', { type: 'text', 'class': 'edit-input', value: element.innerHTML.trim() });
        }

        var saveButton = new Element('button', { 'class': 'save-button' }).update('Save');
        var cancelButton = new Element('button', { 'class': 'cancel-button' }).update('Cancel');

        element.insert({ after: inputElement });
        inputElement.insert({ after: saveButton });
        saveButton.insert({ after: cancelButton });

        saveButton.observe('click', this.saveField.bind(this, element, inputElement, field, originalContent));
        cancelButton.observe('click', this.cancelEdit.bind(this, element, inputElement, saveButton, cancelButton));
    },

    saveField: function (element, inputElement, field, originalContent) {
        var newValue = inputElement.value;
        var ticketId = this.ticketId;
        console.log(ticketId);

        new Ajax.Request(this.redirectUrl, {
            method: 'post',
            parameters: {
                ticket_id: ticketId,
                field: field,
                value: newValue,
                form_key: this.formData
            },
            onSuccess: function (response) {
                var json = response.responseText.evalJSON();
                if (json.success) {
                    element.innerHTML = json.newValue;
                    element.show();
                    inputElement.remove();
                    element.next('.save-button').remove();
                    element.next('.cancel-button').remove();
                } else {
                    alert('Failed to update the field.');
                    element.innerHTML = originalContent;
                    element.show();
                }
            }
        });
    },

    cancelEdit: function (element, inputElement, saveButton, cancelButton) {
        element.show();
        inputElement.remove();
        saveButton.remove();
        cancelButton.remove();
    }
});
