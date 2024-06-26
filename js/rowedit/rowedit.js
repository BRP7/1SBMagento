
var j = jQuery.noConflict();

j(document).ready(function () {
    var status = [];
    j("body").on("click", ".edit-row", function (e) {
        e.preventDefault();

        var editButton = j(this);
        var editUrl = editButton.data("url");
        var id = editButton.data("entity-id");
        status = editButton.data("status");
        console.log(status)
        var className = ".editable-" + id;

        j(className).each(function () {
            // Handle name
            var rowName = j(this).find(".row_name");
            var rowNameText = rowName.text().trim();
            rowName.html('<input type="text" class="edit-input" value="' + rowNameText + '" data-original="' + rowNameText + '">');

            // Handle description
            var rowDescription = j(this).find(".description");
            var rowDescriptionText = rowDescription.text().trim();
            rowDescription.html('<input type="text" class="edit-input" value="' + rowDescriptionText + '" data-original="' + rowDescriptionText + '">');


            var statusRow = j(this).find(".status");
            var statusText = statusRow.text().trim();
            console.log(statusText);
            var dropdown = '<select class="status">';
            Object.keys(status).forEach((element) => {
                // console.log(21,status[element]);
                dropdown +=
                    '<option value="' + element + '" ' + (statusText == status[element] ? "selected" : "") + ' data-original="' + statusText + '">' + status[element] + "</option>";
            });
            dropdown += "</select>";
            statusRow.html(dropdown);


            // Handle date/time fields (assuming they are datetime inputs)
            var createdDate = j(this).find(".created_date");
            var createdDateText = createdDate.text().trim();
            createdDate.html('<input type="datetime-local" class="edit-input" value="' + formatDateForServer(createdDateText) + '" data-original="' + createdDateText + '">');

            var updatedDate = j(this).find(".updated_date");
            var updatedDateText = updatedDate.text().trim();
            updatedDate.html('<input type="datetime-local" class="edit-input" value="' + formatDateForServer(updatedDateText) + '" data-original="' + updatedDateText + '">');

            editButton.hide();
            var saveButton = j('<a href="#" data-url="' + editUrl + '" data-entity-id="' + id + '" class="save-button">Save</a>');
            var cancelButton = j('<a href="#" style="padding-left:5px" data-url="' + editUrl + '" data-entity-id="' + id + '" class="cancel-button">Cancel</a>');
            var buttonContainer = j("<div>").addClass("button-container").append(saveButton, cancelButton);
            var cell = editButton.closest("td");
            cell.empty().append(buttonContainer);
        });
    });

    j("body").on("click", ".save-button", function (e) {
        e.preventDefault();
        var saveButton = j(this);
        var editUrl = saveButton.data("url");
        var rowId = saveButton.data("entity-id");
        var formKey = FORM_KEY; // Ensure FORM_KEY is defined
        var className = ".editable-" + rowId;

        var editedData = {};

        j(className).each(function () {
            var rowName = j(this).find(".row_name .edit-input");
            var rowNameText = rowName.val().trim();
            editedData["name"] = rowNameText;
            rowName.closest('.row_name').text(rowNameText);

            var rowDescription = j(this).find(".description .edit-input");
            var rowDescriptionText = rowDescription.val().trim();
            editedData["description"] = rowDescriptionText;
            rowDescription.closest('.description').text(rowDescriptionText);

            var rowStatus = j(this).find(".status");
            var rowStatusText = rowStatus.find("select").val();
            console.log(status);
            editedData["status"] = rowStatusText;
            rowStatus.text(status[rowStatusText]);

            // var statusRow = j(this).find(".status");
            // var statusText = statusRow.find("select").val();
            // editedData["status"] = statusText;
            // statusRow.text(status[statusText]);


            var createdDate = j(this).find(".created_date .edit-input");
            var createdDateText = createdDate.val().trim();
            editedData["created_date"] = formatDateForServer(createdDateText);
            createdDate.closest('.created_date').text(createdDateText);

            var updatedDate = j(this).find(".updated_date .edit-input");
            var updatedDateText = updatedDate.val().trim();
            editedData["updated_date"] = formatDateForServer(updatedDateText);
            updatedDate.closest('.updated_date').text(updatedDateText);
        });

        j.ajax({
            url: editUrl,
            type: "POST",
            dataType: "json",
            data: {
                "form_key": formKey,
                "entity_id": rowId,
                "name": editedData['name'],
                "description": editedData['description'],
                "status": editedData['status'],
                "created_date": editedData['created_date'],
                "updated_date": editedData['updated_date'],
            },
            success: function (response) {
                console.log("Data saved successfully:", response);
            },
            error: function (xhr, status, error) {
                console.error("Error saving data:", error);
            },
        });
        var cell = saveButton.closest("td");
        var a = j('<a>').text("Edit").attr("href", "#").addClass("edit-row").data("url", editUrl).data("entity-id", rowId).data("status", status);
        cell.empty().append(a);
    });
    j("body").on("click", ".cancel-button", function (e) {
        e.preventDefault();
        var cancelButton = j(this);
        var rowId = cancelButton.data("entity-id");
        var className = ".editable-" + rowId;

        j(className).each(function () {
            var rowName = j(this).find(".row_name .edit-input");
            var rowNameText = rowName.data('original');
            rowName.closest('.row_name').text(rowNameText);

            var rowDescription = j(this).find(".description .edit-input");
            var rowDescriptionText = rowDescription.data('original');
            rowDescription.closest('.description').text(rowDescriptionText);

            var createdDate = j(this).find(".created_date .edit-input");
            var createdDateText = createdDate.data('original');
            createdDate.closest('.created_date').text(createdDateText);

            var statusRow = j(this).find(".status");
            console.log(statusRow);
            var statusText = statusRow.find("select").children('option:selected').data('original');
            console.log(statusText);
            statusRow.text(statusText);

            var updatedDate = j(this).find(".updated_date .edit-input");
            var updatedDateText = updatedDate.data('original');
            updatedDate.closest('.updated_date').text(updatedDateText);
        });

        var cell = cancelButton.closest("td");
        var a = j('<a>').text("Edit").attr("href", "#").addClass("edit-row").data("url", cancelButton.data('url')).data("entity-id", rowId).data("status", status);
        cell.empty().append(a);
    });
});

function formatDateForServer(dateTimeString) {
    // Parse the date and time string into a Date object
    var date = new Date(dateTimeString);

    // Format the date and time into the desired format
    var formattedDateTime = date.getFullYear() + '-' +
        ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
        ('0' + date.getDate()).slice(-2) + 'T' +
        ('0' + date.getHours()).slice(-2) + ':' +
        ('0' + date.getMinutes()).slice(-2);

    return formattedDateTime;
}

document.addEventListener("DOMContentLoaded", function() {
    // Your code here
    const button = document.getElementsByClassName('cus');
    console.log(button);
    j(button).on("click", roweditGrid_massactionJsObject.customFunction);
    // button.setAttribute('onclick', 'gridMassaction.customFunction()');
});
// const button=document.createElement('button');
// div.setAttribute('value','Click Here')
// div.setAttribute('onclick','gridMassaction.customFunction()');
// body.append(button);
// if (typeof varienGridMassaction !== 'undefined') {
    varienGridMassaction.prototype.customFunction = function() {
        alert('Custom Mass Grid Function Called');
        // Your custom code here
    };
// }

varienGrid.prototype.doFilter = function () {
    var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
    var elements = [];
    filters.push(customtextbox);
    for (var i in filters) {
        if (filters[i].value && filters[i].value.length) elements.push(filters[i]);
    }
    console.log(elements);
    // debugger;
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }

};