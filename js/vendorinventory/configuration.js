var j = jQuery.noConflict();
var Configuration = Class.create();

Configuration.prototype = {
    initialize: function (options) {
        this.containerId = options.containerId;
        this.getheaderActionUrl = options.url;
        this.form_key = options.form_key;
        this.row_count = [];
        // this.isUploaded = false;
        // console.log(options);
        this.loadUploadContainer();
    },
    loadUploadContainer: function (event) {
        // console.log(j("#brand-dropdown"))
        var brandDropdown = $(this.containerId).down('#brand-dropdown');
        var fileUploadContainer = $(this.containerId).down('#file-upload-container');
        var headerUrl = this.getheaderActionUrl;
        var formKey = this.form_key;
        brandDropdown.observe('change', function (event) {
            var selectedBrand = this.value;
            if (selectedBrand) {
                // load the file uploader and upload button
                fileUploadContainer.innerHTML = '<input type="file" id="file-upload" accept=".csv,.xml,.xls" name="file-upload"><button id="upload-btn">Upload</button>';
                // handle upload button click
                $('upload-btn').observe('click', function (event) {
                    event.preventDefault();
                    // get the file
                    var files = document.getElementById("file-upload").files;
                    
                    if (files.length > 0 ) {
                        // append file in formData
                        var formData = new FormData();
                        var formData1 = new FormData();
                        formData1.append("name", "asfasd");
                        // console.log(formData1);
                        var file = files[0];
                        // var allowedExtensions = ['csv', 'xml']
                        // console.log(file);
                        // if(file.name.split('.'))
                        formData.append('file-upload', file);
                        formData.append('form_key', formKey);
                        // console.log(formData);
                        // console.log(headerUrl);
                        j.ajax({
                            url: headerUrl,
                            type: 'POST',
                            data: formData,
                            processData: false, // Prevent jQuery from automatically processing the data
                            contentType: false, // Prevent jQuery from setting the content type
                            success: function (response) {                                // console.log(JSON.parse(response));
                                // var headers = response.headers;
                                console.log(response);
                                // if (!Configuration.prototype.isUploaded && response.headers.headers) {
                                //     Configuration.prototype.isUploaded = true;
                                    Configuration.prototype.renderTable(response.headers);
                                // }
                            },
                            error: function () {
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
    renderTable: function (headers) {
        var tableContainer = document.getElementById('table-container');
        var tableHeader = ['ISB Columns', 'Brand Column', 'Data Type', 'Condition Operator', 'Condition Value'];
        var ISBColumns = ['sku', 'instock', 'instock qty', 'restock date', 'restock qty', 'status', 'discontinued'];
        var brandColumn = headers;
        var dataType = ['Count', 'Text', 'Number', 'Date'];
        var conditionOperator = ['=', '>', '<', '>=', '<=', '!='];
        // create table element
        var table = document.createElement('table');
        table.border = 1;
        // create header row
        var tr1 = document.createElement('tr');
        for (var i = 0; i < tableHeader.length; i++) {
            var th = document.createElement('th');
            th.innerText = tableHeader[i];
            tr1.appendChild(th);
        }
        table.appendChild(tr1);
        var brandSelect = this.createDropDown(brandColumn);
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
            addButton.onclick = () => {
                this.handleAdd(event.target);
            };
            td6.appendChild(addButton);

            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);
            // this.row_count.tr = 1;
            table.appendChild(tr);
        }
        tableContainer.appendChild(table)
        var saveBtn = this.createButton('save');
        saveBtn.onclick = () => {
            this.handleSave();
        };
        tableContainer.appendChild(saveBtn);
    },
    handleAdd: function (button) {
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
        p.appendChild(this.createRadioInput("radio_and_" + currentRow[0].id + "_" + (row_count + 1), 'condition_' + currentRow[0].id + '_' + (row_count + 1), 'AND'));
        p.appendChild(label1)
        p.appendChild(this.createRadioInput("radio_or_" + currentRow[0].id + "_" + (row_count + 1), 'condition_' + currentRow[0].id + '_' + (row_count + 1), 'OR'))
        p.appendChild(label2)

        var lastTd = rowClone.lastElementChild;
        if (lastTd) {
            rowClone.removeChild(lastTd);
        }
        // console.log(j(rowClone).find('select'));
        j(rowClone).find('select').eq(0).before(p);
        // rowClone.children[1].children[0].before(p);
        var removeBtn = this.createButton('Delete');
        removeBtn.classList.add('remove-button');
        removeBtn.onclick = () => {
            this.handleDelete(event.target);
        }
        rowClone.append(document.createElement('td').appendChild(removeBtn));
        $(currentRow).after(rowClone);

    },
    handleDelete: function (button) {
        var currentRow = button.parentNode;
        currentRow.parentNode.removeChild(currentRow);
    },
    createRadioInput: function (id, name, value) {
        var radioInput = document.createElement('input');
        radioInput.id = id;
        radioInput.name = name;
        radioInput.type = 'radio';
        radioInput.value = value;
        return radioInput;
    },
    createButton: function (text) {
        var button = document.createElement('button');
        button.innerText = text;
        return button;
    },
    createDropDown: function (options) {
        var select = document.createElement('select');
        for (var i = 0; i < options.length; i++) {
            var option = document.createElement('option');
            option.innerText = options[i];
            option.value = options[i];
            select.appendChild(option);
        }
        return select;
    },
    handleSave: function () {
        var brandId = j('#brand-dropdown').val();
        var configArray = {};
        configArray[brandId] = {};
        j("#table-container table tr").not(":first").each(function () {
            var obj = {};
            // console.log(j(this).attr('row_name'));
            var tds = j(this).find("td");
            var name = j(this).attr('row_name');
            var brandCol = tds.eq(1).find('select').val();
            obj[brandCol] = [tds.eq(2).find('select').val(), tds.eq(3).find('select').val(), tds.eq(4).find('input').val()]

            if (configArray[brandId].hasOwnProperty(name)) {
                var radioValue = tds.eq(1).find('input[type="radio"]:checked').val();
                if (radioValue) {
                    // If radio button is checked, include its value in the object
                    configArray[brandId][name].push(radioValue);
                }
                // If it exists, push the obj to the existing array
                configArray[brandId][name].push(obj);
            } else {
                // If it doesn't exist, create a new array with obj
                configArray[brandId][name] = [obj];
            }
            // configArray.brand_id = [tds.eq(0).text()];
        })
        console.log(JSON.stringify(configArray));
    }

}