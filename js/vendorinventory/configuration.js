
var Configuration
Configuration = Class.create();

Configuration.prototype = {
    initialize: function (options) {
        this.containerId = options.containerId
        this.formId = options.form_key
        this.header_url = options.header_url
        this.loadUploadContainer()
        this.isUploaded = false;
        this.attachDeleteButtonListener();
    },
    loadUploadContainer: function (event) {
        var _that = this;
        var brandDropdown = $(this.containerId).down('#brand-dropdown');
        var fileUploadContainer = $(this.containerId).down('#file-upload-container');
        brandDropdown.observe('change', function (event) {
            var selectedBrand = this.value;
            console.log(FORM_KEY)
            if (selectedBrand) {
                fileUploadContainer.innerHTML = `<form enctype="multipart/form-data"> ${_that.formId} <input type="file" id="file-upload" name="file-upload"><button id="upload-btn">Upload</button></form>`;
                $('upload-btn').observe('click', function (event) {
                    event.preventDefault();
                    var files = document.getElementById("file-upload").files;
                    var formData = new FormData();
                    if (files.length > 0) {
                        formData.append('file-upload', files[0]);
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', _that.header_url);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                // console.log(xhr.responseText);
                                var headers = JSON.parse(xhr.responseText);
                                // Assuming response is JSON
                                //  console.log(xhr.response);
                                if (!Configuration.prototype.isUploaded) {
                                    Configuration.prototype.isUploaded = true;
                                    Configuration.prototype.renderTable(headers.headers);
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
    renderTable: function (headers) {
        var tableContainer = document.getElementById('table-container');
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
        var brandSelect = document.createElement('select');
        for (var i = 0; i < brandColumn.length; i++) {
            var option = document.createElement('option');
            option.value = brandColumn[i];
            option.innerText = brandColumn[i];
            brandSelect.appendChild(option);
        }
        var dataTypeSelect = document.createElement('select');
        for (var i = 0; i < dataType.length; i++) {
            var option = document.createElement('option');
            option.value = dataType[i];
            option.innerText = dataType[i];
            dataTypeSelect.appendChild(option);
        }
        var conditionOperatorSelect = document.createElement('select');
        for (var i = 0; i < conditionOperator.length; i++) {
            var option = document.createElement('option');
            option.value = conditionOperator[i];
            option.innerText = conditionOperator[i];
            conditionOperatorSelect.appendChild(option);
        }
        for (var i = 0; i < ISBColumns.length; i++) {
            var tr = document.createElement('tr');
            var td1 = document.createElement('td');
            td1.innerText = ISBColumns[i];
            var td2 = document.createElement('td');
            td2.classList.add('brand-select-cell')
            td2.appendChild(brandSelect.cloneNode(true));
            var td3 = document.createElement('td');
            td3.appendChild(dataTypeSelect.cloneNode(true));
            var td4 = document.createElement('td');
            td4.appendChild(conditionOperatorSelect.cloneNode(true));
            var td5 = document.createElement('td');
            var input = document.createElement('input');
            input.type = 'text';
            td5.appendChild(input);
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
        tableContainer.appendChild(table)
        tableContainer.addEventListener('click', function (event) {
            // Check if the clicked element is an "Add" button
            if (event.target && event.target.tagName === 'BUTTON' && event.target.classList.contains('add-button')) {
                // Call handleAdd function passing the clicked button and the event object
                this.handleAdd(event.target);
            }
        }.bind(this));
    },
    handleAdd: function(button) {
        var currentRow = button.parentNode.parentNode;
        var rowClone = currentRow.cloneNode(true); // Clone the current row
        var brandSelectCell = rowClone.children[1]; // Assuming brand select cell is at index 1
    
        // Remove existing delete button from cloned row, if present
        var existingDeleteBtn = rowClone.querySelector('.deletebtn');
        if (existingDeleteBtn) {
            existingDeleteBtn.parentNode.removeChild(existingDeleteBtn);
        }
    
        var inputFields = rowClone.querySelectorAll('input[type=text], input[type=number],input[type=select]');
        inputFields.forEach(function(input) {
            input.value = ''; // Reset input value to empty string
        });
    
        // Remove existing radio inputs
        var radioInputs = brandSelectCell.querySelectorAll('input[type=radio]');
        radioInputs.forEach(function(input) {
            input.parentNode.removeChild(input);
        });
    
        var labels = brandSelectCell.querySelectorAll('label');
        labels.forEach(function(label) {
            label.parentNode.removeChild(label);
        });
    
        // Create and append new radio inputs
        var label1 = document.createElement('label');
        label1.innerText = "AND";
        label1.setAttribute("for", "radio_and");
        var label2 = document.createElement('label');
        label2.innerText = "OR";
        label2.setAttribute("for", "radio_or");
    
        var p = document.createElement('p');
        p.appendChild(this.createRadioInput('radio_and', 'condition', 'AND'));
        p.appendChild(label1);
        p.appendChild(this.createRadioInput('radio_or', 'condition', 'OR'));
        p.appendChild(label2);
        brandSelectCell.appendChild(p); // Append radio inputs to the cell
    
        // Create delete button
        var del = document.createElement('button');
        del.innerText = "Delete"; // Set button text
        del.classList.add('deletebtn'); // Add a class to the delete button
    
        // Attach event listener to delete button
        del.addEventListener("click", function() {
            // Remove the row clone when the delete button is clicked
            rowClone.parentNode.removeChild(rowClone);
        });
    
        // Append delete button to the cloned row
        rowClone.appendChild(del);
    
        // Insert the cloned row after the current row
        currentRow.parentNode.insertBefore(rowClone, currentRow.nextSibling);
    },
    
    
    
    
    createRadioInput: function(id, name, value) {
        var radioInput = document.createElement('input');
        radioInput.id = id;
        radioInput.name = name;
        radioInput.type = 'radio';
        radioInput.value = value;
        return radioInput;
    },
    handleDelete: function(deleteButton) {
        var rowToDelete = deleteButton.parentNode;
        rowToDelete.parentNode.removeChild(rowToDelete);
    },
    attachDeleteButtonListener: function() {
        var _that = this;
        document.getElementById('table-container').addEventListener('click', function(event) {
            if (event.target && event.target.tagName === 'BUTTON' && event.target.classList.contains('deletebtn')) {
                _that.handleDelete(event.target);
            }
        });
    },
}