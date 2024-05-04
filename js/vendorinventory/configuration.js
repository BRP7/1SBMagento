var j = jQuery.noConflict();
var Configuration = Class.create();

Configuration.prototype = {
  initialize: function (options) {
    this.containerId = options.containerId;//object.extends(this)
    this.getheaderActionUrl = options.url;
    this.form_key = options.form_key;
    this.row_count = [];
    // this.isUploaded = false;
    this.loadUploadContainer();
  },
  loadUploadContainer: function (event) {
    var self = this;
    var brandDropdown = $(this.containerId).down("#brand-dropdown");
    var fileUploadContainer = $(this.containerId).down(
      "#file-upload-container"
    );
    var headerUrl = this.getheaderActionUrl;
    var formKey = this.form_key;
    // console.log(formKey)
    console.log(headerUrl);
    brandDropdown.observe("change", function (event) {
      var selectedBrand = this.value;
      // echo selectedBrand;
      // console.log(selectedBrand);
      if (selectedBrand) {
        fileUploadContainer.innerHTML =
          '<input type="file" id="file-upload" accept=".csv,.xml,.xls" name="file-upload"><button id="upload-btn">Upload</button>';
        // handle upload button click
        $("upload-btn").observe("click", function (event) {
          event.preventDefault();
          // get the file
          var files = document.getElementById("file-upload").files;
          var formData = new FormData();

          if (files.length > 0) {
            // append file in formData
            var file = files[0];
            // var allowedExtensions = ['csv', 'xml']
            // console.log(file);
            // if(file.name.split('.'))
            formData.append("file-upload", file);
            formData.append("form_key", formKey);
            formData.append("brand_id", selectedBrand);
            j.ajax({
              url: headerUrl,
              type: "POST",
              data: formData,
              processData: false, // Prevent jQuery from automatically processing the data
              contentType: false, // Prevent jQuery from setting the content type
              success: function (response) {
                console.log(response);
                // return
                var brand_data = response.brand;
                var headers = response.headers;
                console.log(self.form_key);
                if (response.hasOwnProperty('config_id')) {
                  var config_id = response.config_id;
                  var id = response.id;
                  self.renderTable(headers, brand_data, config_id, id);
                } else {
                  self.renderTable(headers, brand_data);
                }

                //    var sku = brand_data[0];
                // console.log(brand_data);
                // return;
                // console.log(headers);
                // if (!Configuration.prototype.isUploaded && headers.headers) {
                // Configuration.prototype.isUploaded = true;
                // }
              },
              error: function () {
                alert("Failed to retrieve CSV headers.");
              },
            });
          } else {
            alert("Please select a file.");
          }
        });
      } else {
        fileUploadContainer.innerHTML = "";
      }
    });
  },
  renderTable: function (headers, brand_data = false, config_id = 0, id = 0) {
    // console.log(config_id)
    // console.log(id)
    var self = this;
    // console.log(this.formKey);
    var table = this.createHTMLElement("table");
    var tableContainer = document.getElementById("table-container");
    var tableHeader = [
      "ISB Columns",
      "Brand Column",
      "Data Type",
      "Condition Operator",
      "Condition Value",
    ];
    var ISBColumns = [
      "sku",
      "instock",
      "instock_qty",
      "restock_date",
      "restock_qty",
      "status",
      "discontinued",
    ];
    var dataType = ["Count", "Text", "Number", "Date"];
    var conditionOperator = ["=", ">", "<", ">=", "<=", "!="];
    // Check if brandData is empty

    var tr1 = document.createElement("tr");
    for (var i = 0; i < tableHeader.length; i++) {
      var th = document.createElement("th");
      th.innerText = tableHeader[i];
      tr1.appendChild(th);
    }
    table.appendChild(tr1);

    // Create dropdowns for each option
    var brandSelect = this.createDropDown(headers, brand_data);
    var dataTypeSelect = this.createDropDown(dataType);
    var conditionOperatorSelect = this.createDropDown(conditionOperator);

    for (var i = 0; i < ISBColumns.length; i++) {
      var tr = document.createElement("tr");
      tr.id = "row_" + i;
      tr.classList.add("row_" + i);
      tr.setAttribute("row_id", "row_" + i);
      tr.setAttribute("row_name", ISBColumns[i]);

      // Create cells for each column
      var td1 = document.createElement("td");
      td1.innerText = ISBColumns[i];

      var td2 = document.createElement("td");
      td2.classList.add("brand-select-cell");
      td2.appendChild(brandSelect.cloneNode(true));

      var td3 = document.createElement("td");
      td3.appendChild(dataTypeSelect.cloneNode(true));

      var td4 = document.createElement("td");
      td4.appendChild(conditionOperatorSelect.cloneNode(true));

      var td5 = document.createElement("td");
      var input = document.createElement("input");
      input.type = "text";
      td5.appendChild(input);

      var td6 = document.createElement("td");
      var addButton = document.createElement("button");
      addButton.classList.add("add-button");
      addButton.innerText = "Add";
      addButton.onclick = () => {
        self.handleAdd(event.target);
      };
      td6.appendChild(addButton);

      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);
      tr.appendChild(td5);
      tr.appendChild(td6);
      table.appendChild(tr);
      // Clear previous content and append the table to the container
      tableContainer.innerHTML = "";
      tableContainer.appendChild(table);

      // Add save button
      var saveBtn = document.createElement("button");
      saveBtn.innerHTML = "Save";
      saveBtn.onclick = () => {
        self.handleSave(config_id, id);
      };
      tableContainer.appendChild(saveBtn);
    }
    if (brand_data !== false) {
      console.log(brand_data);
      this.createConfigData(brand_data);
    }
  },

  createConfigData: function (brand_data) {
    var self = this;
    j("#table-container table tr")
      .not(":first")
      .each(function (index, tr) {
        var configData = brand_data[tr.getAttribute("row_name")];
        var p;
        configData.forEach(function (row, index) {
          if (index >= 1) {
            if (row == "AND" || row == "OR") {
              var radioAnd = self.createRadioInput(
                "radio_and_" + configData + "_clone_" + index,
                "condition_radio_" + configData + "_clone_" + index,
                "AND"
              );
              var labelAnd = document.createElement("label");
              labelAnd.innerText = "AND";
              labelAnd.htmlFor = "radio_and_" + configData + "_clone_" + index;
              var radioOr = self.createRadioInput(
                "radio_or_" + configData + "_clone_" + index,
                "condition_radio_" + configData + "_clone_" + index,
                "OR"
              );
              var labelOr = document.createElement("label");
              labelOr.innerText = "OR";
              labelOr.htmlFor = "radio_or_" + configData + "_clone_" + index;

              if (configData[index] == "AND") {
                radioAnd.checked = true;
              } else {
                radioOr.checked = true;
              }
              p = document.createElement('p');
              p.appendChild(radioOr);
              p.appendChild(labelOr);
              p.appendChild(radioAnd);
              p.appendChild(labelAnd);
            } else {
              var trClone = tr.cloneNode(true);
              var tds = j(trClone).find("td");
              for (const _row in row) {
                // console.log(row[_row]);
                tds.eq(1).find("select").val(_row);
                tds.eq(2).find("select").val(row[_row]["dataType"]);
                tds.eq(3).find("select").val(row[_row]["operator"]);
                tds.eq(4).find("input").val(row[_row]["dataValue"]);
              }

              trClone.firstChild.innerText = "";
              tds.eq(1).find("select").before(p);
              j(tr).after(trClone);
            }
          } else {
            var tds = j(tr).find("td");
            for (var _row in row) {
              tds.eq(1).find("select").val(_row);
              tds.eq(2).find("select").val(row[_row]["dataType"]);
              tds.eq(3).find("select").val(row[_row]["operator"]);
              tds.eq(4).find("input").val(row[_row]["dataValue"]);
            }
          }
        });
      });
  },

  // Check if brand_data has additional rows for the current ISB column
  handleAdd: function (button) {
    var currentRow = j(button).parents("tr");
    // console.log("ccc",currentRow);
    var row_id = currentRow[0].getAttribute("row_id");
    var row_count = j("#table-container")
      .children("table")
      .find("tr[row_id=" + row_id + "]").length;
    var rowClone = currentRow[0].cloneNode(true);
    rowClone.firstChild.innerText = "";
    var label1 = document.createElement("label");
    label1.innerText = "AND";
    label1.setAttribute(
      "for",
      "radio_and_" + currentRow[0].id + "_" + (row_count + 1)
    );
    var label2 = document.createElement("label");
    label2.innerText = "OR";
    label2.setAttribute(
      "for",
      "radio_or_" + currentRow[0].id + "_" + (row_count + 1)
    );

    var p = document.createElement("p");
    p.appendChild(
      this.createHTMLElement("input", {
        type: "radio",
        id: "radio_and_" + currentRow[0].id + "_" + (row_count + 1),
        name: "condition_" + currentRow[0].id + "_" + (row_count + 1),
        value: "AND",
      })
    );
    p.appendChild(label1);
    p.appendChild(
      this.createHTMLElement("input", {
        type: "radio",
        id: "radio_or_" + currentRow[0].id + "_" + (row_count + 1),
        name: "condition_" + currentRow[0].id + "_" + (row_count + 1),
        value: "OR",
      })
    );
    p.appendChild(label2);

    var inputFields = rowClone.querySelectorAll(
      "input[type=text], input[type=number]"
    );
    inputFields.forEach(function (input) {
      input.value = "";
    });

    var lastTd = rowClone.lastElementChild;
    if (lastTd) {
      rowClone.removeChild(lastTd);
    }
    // console.log(j(rowClone).find('select'));
    j(rowClone).find("select").eq(0).before(p);
    // rowClone.children[1].children[0].before(p);
    var removeBtn = this.createHTMLElement("button");
    removeBtn.innerText = "Delete";
    removeBtn.classList.add("remove-button");
    removeBtn.onclick = () => {
      this.handleDelete(event.target);
    };
    rowClone.append(document.createElement("td").appendChild(removeBtn));
    $(currentRow).after(rowClone);
  },
  handleDelete: function (button) {
    var currentRow = button.parentNode;
    currentRow.parentNode.removeChild(currentRow);
  },

  createDropDown: function (options) {
    var select = document.createElement("select");

    for (var i = 0; i < options.length; i++) {
      var option = document.createElement("option");
      option.innerText = options[i];
      option.value = options[i];

      // var isSelected = false; // Flag to track if an option is selected

      // // Iterate through the brand_data object keys
      // for (var key in brand_data[0]) {
      //     if (key == options[i] && !isSelected) { // Check if option should be selected and if it's not already selected
      //         console.log("123" + key);
      //         option.selected = "selected"; // Select the option
      //         isSelected = true; // Set the flag to true
      //     }
      //     break;
      // }
      select.appendChild(option);
    }
    return select;
  },

  createRadioInput: function (id, name, value) {
    var radioInput = document.createElement("input");
    radioInput.id = id;
    radioInput.name = name;
    radioInput.type = "radio";
    radioInput.value = value;
    return radioInput;
  },
  createHTMLElement: function (element, attributes) {
    var elem = document.createElement(element);
    if (attributes) {
      for (var key in attributes) {
        if (attributes.hasOwnProperty(key)) {
          elem.setAttribute(key, attributes[key]);
        }
      }
    }
    return elem;
  },
  handleSave: function (configId = 0, id = 0) {
    var self = this;
    // console.log(config_id);
    // console.log(id);
    var brandId = j("#brand-dropdown").val();
    // var configId;
    // var primaryKey = "primary_key";
    // var autoId;
    var configArray = {};

    // var bId;
    // configArray["from_id"] = self.form_key;
    // console.log(this.form_key);
    var fromKey = this.form_key;
    // return

    if (configId != 0 && id != 0) {
      configArray["config_id"] = configId;
      configArray["primary_key"] = id;
    }

    configArray[brandId] = {};
    j("#table-container table tr")
      .not(":first")
      .each(function () {
        var obj = {};
        // console.log(j(this).attr('row_name'));
        var tds = j(this).find("td");
        // console.log(tds);
        var name = j(this).attr("row_name");
        //   console.log(name)
        var brandCol = tds.eq(1).find("select").val();
        obj[brandCol] = {
          'dataType' : tds.eq(2).find("select").val(),
          'operator' : tds.eq(3).find("select").val(),
          'dataValue': tds.eq(4).find("input").val(),
        };

        if (configArray[brandId].hasOwnProperty(name)) {
          console.log(configArray[brandId]);
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
      });


    var jsonData = JSON.stringify(configArray);
    console.log(JSON.stringify(configArray));
    // return
    j.ajax({
      url: "http://127.0.0.1/1SBMagento/index.php/admin/VendorInventory/upload",
      type: "POST",
      data: { jsonData: jsonData, "form_key": fromKey },
      success: function (response) {
        // console.log(response);
        // Handle success response from PHP controller
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  },
};
