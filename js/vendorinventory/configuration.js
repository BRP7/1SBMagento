var j = jQuery.noConflict();
var Configuration = Class.create();

Configuration.prototype = {
    initialize: function(options) {
        this.containerId = options.containerId;
        this.getheaderActionUrl = options.url;
        this.form_key = options.form_key;
        this.row_count = [];
        this.redirectUrl = options.redirected_url;
        this.loadUploadContainer();
    },
    loadUploadContainer: function(event) {
        var self = this;
        var brandDropdown = $(this.containerId).down('#brand-dropdown');
        var fileUploadContainer = $(this.containerId).down('#file-upload-container');
        var headerUrl = this.getheaderActionUrl;
        var formKey = this.form_key;
        brandDropdown.observe('change', function(event) {
            var selectedBrand = this.value;
            if (selectedBrand) {
                fileUploadContainer.innerHTML = '<input type="file" id="file-upload" accept=".csv,.xml,.xls" name="file-upload"><button id="upload-btn">Upload</button>';
                $('upload-btn').observe('click', function(event) {
                    event.preventDefault();
                    var files = document.getElementById("file-upload").files;
                    if (files.length > 0) {
                        var formData = new FormData();
                        formData.append("name", "asfasd");
                        formData.append("brand_id", selectedBrand);
                        var file = files[0];
                        formData.append('file-upload', file);
                        formData.append('form_key', formKey);
                        j.ajax({
                            url: headerUrl,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log(response['brand_data']);
                                self.renderTable(response.headers, response['brand_data']);
                            },
                            error: function() {
                                alert('Failed to retrieve CSV headers.');
                            }
                        });
                    } else {
                        alert('Please select a file.');
                    }
                });
            } else {
                fileUploadContainer.innerHTML = '';
            }
        });
    },
    renderTable: function(headers, brandData = {}) {
        var self = this;
        var tableContainer = document.getElementById('table-container');
        
        // Check if brandData is empty
        if (Object.keys(brandData).length === 0) {
            tableContainer.innerHTML = '<p>No data available</p>';
            return;
        }
        
        var table = document.createElement('table');
        table.border = 1;
        
        var tableHeader = ['ISB Columns', 'Brand Column', 'Data Type', 'Condition Operator', 'Condition Value'];
        var ISBColumns = ['sku', 'instock', 'instock qty', 'restock date', 'restock qty', 'status', 'discontinued'];
        var dataType = ['Count', 'Text', 'Number', 'Date'];
        var conditionOperator = ['=', '>', '<', '>=', '<=', '!='];

        var brandSelect = this.createDropDown(headers, brandData);
        var dataTypeSelect = this.createDropDown(dataType);
        var conditionOperatorSelect = this.createDropDown(conditionOperator);

        for (var i = 0; i < ISBColumns.length; i++) {
            var tr = document.createElement('tr');
            tr.id = 'row_' + i;
            tr.classList.add('row_' + i);
            tr.setAttribute("row_id", "row_" + i);
            tr.setAttribute("row_name", ISBColumns[i]);

            var td1 = document.createElement('td');
            td1.innerText = ISBColumns[i];

            var td2 = document.createElement('td');
            td2.classList.add('brand-select-cell');
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
            addButton.onclick = () => { self.handleAdd(event.target); };
            td6.appendChild(addButton);

            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);
            table.appendChild(tr);

            if (brandData.hasOwnProperty(ISBColumns[i])) {
                for (var j = 0; j < brandData[ISBColumns[i]].length; j++) {
                    var brandDataRow = brandData[ISBColumns[i]];
                    // console.log(brandDataRow.length);
                    // console.log(tr);
                    if(brandDataRow.length !== 1){
                        var trClone = tr.cloneNode(true);
                        trClone.setAttribute('row_id', 'row_' + i + '_clone_' + j);
                        trClone.setAttribute('class', 'row_' + i + '_clone');
                        trClone.setAttribute('row_name', ISBColumns[i] + '_clone_' + j);
                        trClone.firstChild.innerText = '';
                    }
                    var brandDataRow = brandData[ISBColumns[i]][j];
                    var tdSelect = trClone.querySelector('.brand-select-cell select');
                    tdSelect.value = ISBColumns[i];
                    for (var key in brandDataRow) {
                        if (brandDataRow.hasOwnProperty(key)) {
                            console.log("value ",brandDataRow[key])
                            var tdIndex = Array.from(trClone.children).findIndex(function(cell) {
                                return cell.classList.contains(key.replaceAll(' ', '_'));
                            });
                            console.log(tdIndex);
                            
                            var td = trClone.children[tdIndex];
                            

                            if (td) {
                                var select = td.querySelector('select');
                                if (select) {
                                    select.value = brandDataRow[key];
                                }
                            }
                        }
                    }
                    table.appendChild(trClone);
                }
            }
        }
        tableContainer.innerHTML = ''; // Clear previous content
        tableContainer.appendChild(table);

        var saveBtn = document.createElement('button');
        saveBtn.innerHTML = "save";
        saveBtn.onclick = () => { self.handleSave(); };
        tableContainer.appendChild(saveBtn);
    },
    handleAdd: function(button) {
        var currentRow = j(button).parents("tr");
        var row_id = currentRow[0].getAttribute("row_id");
        var row_count = j("#table-container").children("table").find("tr[row_id=" + row_id + "]").length;
        var rowClone = currentRow[0].cloneNode(true);
        rowClone.firstChild.innerText = '';
        var label1 = document.createElement('label');
        label1.innerText = "AND";
        label1.setAttribute("for", "radio_and_" + currentRow[0].id + "_" + (row_count + 1))
        var label2 = document.createElement('label');
        label2.innerText = "OR";
        label2.setAttribute("for", "radio_or_" + currentRow[0].id + "_" + (row_count + 1))
        var p = document.createElement('p');
        p.appendChild(label1);
        p.appendChild(label2);
        rowClone.insertBefore(p, rowClone.childNodes[4]);
        var removeButton = document.createElement('button');
        removeButton.classList.add('remove-button');
        removeButton.innerText = "Remove";
        removeButton.onclick = () => { this.handleRemove(event.target); };
        rowClone.appendChild(removeButton);
        currentRow[0].parentNode.insertBefore(rowClone, currentRow[0].nextSibling);
    },
    handleSave: function() {
        var tableRows = j("#table-container").children("table").find("tr");
        var postData = [];
        for (var i = 0; i < tableRows.length; i++) {
            var row_id = tableRows[i].getAttribute("row_id");
            var rowData = {};
            rowData['ISB_Column'] = j(tableRows[i]).find('td')[0].innerText;
            rowData['Brand_Column'] = j(tableRows[i]).find('td')[1].querySelector('select').value;
            rowData['Data_Type'] = j(tableRows[i]).find('td')[2].querySelector('select').value;
            rowData['Condition_Operator'] = j(tableRows[i]).find('td')[3].querySelector('select').value;
            rowData['Condition_Value'] = j(tableRows[i]).find('td')[4].querySelector('input').value;
            postData.push(rowData);
        }
        j.ajax({
            url: this.redirectUrl,
            type: 'POST',
            data: {
                form_key: this.form_key,
                data: JSON.stringify(postData)
            },
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert('Failed to save data.');
            }
        });
    },
    handleRemove: function(button) {
        j(button).parents("tr").remove();
    },
    createDropDown: function(options) {
        var select = document.createElement('select');
        for (var i = 0; i < options.length; i++) {
            var option = document.createElement('option');
            option.value = options[i];
            option.text = options[i];
            select.appendChild(option);
        }
        return select;
    }
}
