
var Configuration
Configuration = Class.create();

Configuration.prototype = {
    initialize: function (options) {
        this.containerId = options.containerId
        this.formId = options.form_key
        this.header_url = options.header_url
        this.post_data = options.post_data;
        this.loadUploadContainer()
        this.isUploaded = false;
    },
    loadUploadContainer: function (event) {
        var _that = this;
        console.log(_that.post_data);
        var brandDropdown = $(this.containerId).down('#brand-dropdown');
        var fileUploadContainer = $(this.containerId).down('#file-upload-container');
        brandDropdown.observe('change', function (event) {
            var selectedBrand = this.value;
            // console.log(FORM_KEY)
            if (selectedBrand) {
                console.log(_that.post_data);
                // fileUploadContainer.innerHTML = `<form enctype="multipart/form-data"> ${_that.formId} <input type="file" id="file-upload" name="file-upload"><button id="upload-btn">Upload</button></form>`;
                fileUploadContainer.innerHTML = `<form enctype="multipart/form-data">  <input type="file" id="file-upload" name="file-upload"><button id="upload-btn">Upload</button></form>`;

                $('upload-btn').observe('click', function (event) {
                    event.preventDefault();
                    var files = document.getElementById("file-upload").files;
                    var formData = new FormData();
                    if (files.length > 0) {
                        formData.append('file-upload', files[0]);
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST',_that.header_url);
                        // var posrUrl =_that.post_data;
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                console.log(xhr.responseText);
                                var headers = JSON.parse(xhr.responseText);
                                var posrUrl =_that.post_data;
                                // Assuming response is JSON
                                console.log(xhr.response);
                                if (!Configuration.prototype.isUploaded) {
                                    Configuration.prototype.isUploaded = true;
                                    Configuration.prototype.renderTable(headers.headers,posrUrl);
                                }
                            } else {
                                alert('Failed to retrieve CSV headers.');
                            }
                        };
                        xhr.onerror = function () {
                            alert('Failed to retrieve CSV headers.');
                        };
                        xhr.send(formData);
                    } else {
                        alert('Please select a file.');
                    }
                });
            } else {
                fileUploadContainer.innerHTML = '';
            }
        });
    },
   
    
    renderTable: function(headers, url) {
        var tableContainer = document.getElementById('table-container');
        var form = document.createElement("form"); // Create a form element
        // Set the action attribute
        form.setAttribute("method", "POST"); // Set the method attribute to POST
        var tableHeader = ['ISB Columns', 'Brand Column', 'Data Type', 'Condition Operator', 'Condition Value'];
        var ISBColumns = ['sku', 'instock', 'instock qty', 'restock date', 'restock qty', 'status', 'discontinued'];
        var brandColumn = headers;
        var dataType = ['Text', 'Number', 'Date'];
        var conditionOperator = ['=', '>', '<', '>=', '<=', '!='];
        var table = document.createElement('table');
        table.border = 1;
        var tr1 = document.createElement('tr');
        for (var i = 0; i < tableHeader.length; i++) {
            var th = document.createElement('th');
            th.innerText = tableHeader[i];
            tr1.appendChild(th);
        }
        table.appendChild(tr1);
    
        for (var i = 0; i < ISBColumns.length; i++) {
            var namePrefix = `brandid_${ISBColumns[i]}_brandcolumn`;
            var tr = document.createElement('tr');
            var td1 = document.createElement('td');
            td1.innerText = ISBColumns[i];
    
            var td2 = document.createElement('td');
            td2.classList.add('brand-select-cell');
            var brandSelect = document.createElement('select');
            for (var j = 0; j < brandColumn.length; j++) {
                var option = document.createElement('option');
                option.value = brandColumn[j];
                option.innerText = brandColumn[j];
                brandSelect.appendChild(option);
            }
            brandSelect.setAttribute("name", `${namePrefix}[][${i}]`);
            td2.appendChild(brandSelect);
    
            var td3 = document.createElement('td');
            var dataTypeSelect = document.createElement('select');
            dataTypeSelect.setAttribute("name", `${namePrefix}[${i}][data_type]`);
            for (var j = 0; j < dataType.length; j++) {
                var option = document.createElement('option');
                option.value = dataType[j];
                option.innerText = dataType[j];
                dataTypeSelect.appendChild(option);
            }
            td3.appendChild(dataTypeSelect);
    
            var td4 = document.createElement('td');
            var conditionOperatorSelect = document.createElement('select');
            conditionOperatorSelect.setAttribute("name", `${namePrefix}[${i}][condition_operation]`);
            for (var j = 0; j < conditionOperator.length; j++) {
                var option = document.createElement('option');
                option.value = conditionOperator[j];
                option.innerText = conditionOperator[j];
                conditionOperatorSelect.appendChild(option);
            }
            td4.appendChild(conditionOperatorSelect);
    
            var td5 = document.createElement('td');
            var inputValueInput = document.createElement('input');
            inputValueInput.setAttribute("name", `${namePrefix}[${i}][inputValue]`);
            inputValueInput.type = 'text';
            td5.appendChild(inputValueInput);
    
            var td6 = document.createElement('td');
            var addButton = document.createElement('button');
            addButton.classList.add('add-button');
            addButton.innerText = "Add";
            td6.appendChild(addButton);
    
            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);
    
            table.appendChild(tr);
        }
        form.appendChild(table); // Append the table to the form
        var saveButton = document.createElement("input");
        saveButton.setAttribute('formaction', url);
        saveButton.type = "submit";
        saveButton.innerText = "Save";
        form.appendChild(saveButton); // Append the save button to the form
    
        tableContainer.appendChild(form);
        tableContainer.addEventListener('click', function(event) {
            // Check if the clicked element is an "Add" button
            if (event.target && event.target.tagName === 'BUTTON' && event.target.classList.contains('add-button')) {
                // Call handleAdd function passing the clicked button and the event object
                this.handleAdd(event.target, event);
            }
        }.bind(this));
    },
    

    handleAdd: function (button,event) {
        event.preventDefault();
        // console.log(1322);
        var configuration = this;
        var currentRow = button.parentNode.parentNode;
        var rowClone = currentRow.cloneNode(true); // Clone the current row

        rowClone.removeAttribute('id');

        this.rowCounter++;

    // Update name attributes of input elements in the cloned row
    var inputs = rowClone.querySelectorAll('input, select');
    inputs.forEach(function(input) {
        var name = input.getAttribute('name');
        if (name) {
            var newName = name + '_' + this.rowCounter;
            input.setAttribute('name', newName);
        }
    }.bind(this));
    
        var brandSelectCell = rowClone.children[1]; // Assuming brand select cell is at index 1

        var inputFields = rowClone.querySelectorAll('input[type=text]', 'input[type=number]');
        inputFields.forEach(function (input) {
            input.value = ''; // Reset input value to empty string
        });
        // Remove existing radio inputs
        var radioInputs = brandSelectCell.querySelectorAll('input[type=radio]');
        radioInputs.forEach(function (input) {
            input.parentNode.removeChild(input);
        });

        var existingDeleteButton = rowClone.querySelector('.delete-button');
        if (existingDeleteButton) {
            existingDeleteButton.remove();
        }

        var labels = brandSelectCell.querySelectorAll('label');
        labels.forEach(function (label) {
            label.parentNode.removeChild(label);
        });
        // Create and append new radio inputs
        var label1 = document.createElement('label');
        label1.innerText = "AND";
        label1.setAttribute("for", "radio_and_" + Date.now()); // Unique ID for AND radio button
        var label2 = document.createElement('label');
        label2.innerText = "OR";
        label2.setAttribute("for", "radio_or_" + Date.now()); // Unique ID for OR radio button

        var p = document.createElement('p');

        var radioAnd = this.createRadioInput('radio_and_' + Date.now(), 'condition_' + Date.now(), 'AND'); // Unique name for each set of radio buttons
        var radioOr = this.createRadioInput('radio_or_' + Date.now(), 'condition_' + Date.now(), 'OR'); // Unique name for each set of radio buttons

        p.appendChild(radioAnd);
        p.appendChild(label1);
        p.appendChild(radioOr);
        p.appendChild(label2);
        brandSelectCell.appendChild(p); // Append radio inputs to the cell

        // Create and append delete button
        var deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-button');
        deleteButton.innerText = "Delete";
        deleteButton.addEventListener('click', function () {
            this.handleDelete(rowClone);
        }.bind(this));
        rowClone.appendChild(deleteButton);
        // Insert the cloned row after the current row
        currentRow.parentNode.insertBefore(rowClone, currentRow.nextSibling);
    },

    createRadioInput: function (id, name, value) {
        var radioInput = document.createElement('input');
        radioInput.id = id;
        radioInput.name = name;
        radioInput.type = 'radio';
        radioInput.value = value;
        return radioInput;
    },

    handleDelete: function (row) {
        row.parentNode.removeChild(row);
    }


}