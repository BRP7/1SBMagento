var j = jQuery.noConflict();
var Configuration = Class.create();

Configuration.prototype = {
    initialize: function (options) {
        this.containerId = options.containerId;
        this.redirectedUrl = options.redirected_url;
        this.tableCounter = 0;
        this.rowCounter = 1;
        this.loadUploadContainer();
    },
    
    loadUploadContainer: function () {
        var self = this;
        j("#add_new_row_btn").on("click", function (event) {
            event.preventDefault();
            self.addNewTable();
        });
          
        j("#save_configuration_btn").on("click", function (event) {
            event.preventDefault();
            self.saveConfiguration();
        });
    },
    
    addNewTable: function () {
        var self = this;
        self.rowCounter = 1;
        var tableContainer = j("#main_container");
        var table = j("<table></table>").attr("id", "table_" + self.tableCounter).appendTo(tableContainer);
        var tableHeader = ["Condition", "Condition Operator", "Condition Value", "Actions", "Dispatch Event"];
        var tr = j("<tr></tr>");
        tableHeader.forEach(function (header) {
            tr.append(j("<th></th>").text(header));
        });
        table.append(tr);
        
        self.addRow(self.tableCounter);
        self.tableCounter++;
    },
    
    addRow: function (tableId) {
        var self = this;
        var table = j("#table_" + tableId);
        var tr = j("<tr></tr>").attr("id", "row_" + self.rowCounter);
        
        tr.append(j("<td></td>").append(self.createDropDown(["subject", "from", "to"], "condition_" + self.rowCounter)));
        tr.append(j("<td></td>").append(self.createDropDown(["=", "%Like%", "Like", ">=", "<=", "!="], "operator_" + self.rowCounter)));
        tr.append(j("<td></td>").append(j("<input>").attr({ type: "text", name: "value_" + self.rowCounter })));
        
        var td = j("<td></td>");
        var addButton = j("<button></button>").text("Add").addClass("add-button").on("click", function (event) {
            event.preventDefault();
            self.handleAdd(this, tableId);
        });
        td.append(addButton);
        
        if (self.rowCounter > 0) {
            var removeButton = j("<button></button>").text("Delete").addClass("remove-button").on("click", function (event) {
                event.preventDefault();
                self.handleDelete(this);
            });
            td.append(removeButton);
        }

        tr.append(td);
        if (self.rowCounter === 1) {
            var dispatchEventTd = j("<td></td>").attr("rowspan", 1).append(j("<input>").attr({ type: "text", id: "dispatchevent", name: "event_" + self.tableCounter }));
            tr.append(dispatchEventTd);
        } else {
            var dispatchEventTd = table.find("td[rowspan]");
            dispatchEventTd.attr("rowspan", parseInt(dispatchEventTd.attr("rowspan")) + 1);
        }

        table.append(tr);
        self.rowCounter++;
    },
    
    createDropDown: function (options, name) {
        var select = j("<select></select>").attr("name", name);
        options.forEach(function (option) {
            select.append(j("<option></option>").val(option).text(option));
        });
        return select;
    },
    
    handleAdd: function (button, tableId) {
        var self = this;
        var currentRow = j(button).closest("tr");
        var newRow = currentRow.clone();
        newRow.find("input, select").each(function () {
            var oldName = j(this).attr("name");
            var newName = oldName.replace(/\d+$/, '') + self.rowCounter;
            j(this).attr("name", newName).val("");
        });
        if (newName !== 'event_1') {
            newRow.find("td:last-child").remove();
        }
        newRow.find(".add-button").on("click", function (event) {
            event.preventDefault();
            self.handleAdd(this, tableId);
        });
        newRow.find(".remove-button").on("click", function (event) {
            event.preventDefault();
            self.handleDelete(this);
        });

        if (newRow.find(".remove-button").length === 0) {
            var removeButton = j("<button></button>").text("Delete").addClass("remove-button").on("click", function () {
                self.handleDelete(this);
            });
            newRow.children("td:last").append(removeButton);
        }

        currentRow.after(newRow);
        var dispatchEventTd = currentRow.closest("table").find("td[rowspan]");
        dispatchEventTd.attr("rowspan", parseInt(dispatchEventTd.attr("rowspan")) + 1);

        self.rowCounter++;
    },

    handleDelete: function (button) {
        let row = j(button).closest("tr");
        var table = row.closest("table");
        var dispatchEventTd = table.find("td[rowspan]");

        if (table.find("tr").length === 2) { 
            table.remove();
        } else {
            row.remove();
            dispatchEventTd.attr("rowspan", parseInt(dispatchEventTd.attr("rowspan")) - 1);
        }
    },

    saveConfiguration: function () {
        var tables = [];
        j("#main_container table").each(function (tableIndex) {
            var table = [];
            j(this).find("tr:gt(0)").each(function () {
                var row = { group_id: tableIndex };
                j(this).find("input, select").each(function () {
                    row[j(this).attr("name")] = j(this).val();
                });
                table.push(row);
            });
            tables.push(table);
        });
        console.log(tables);

        j.ajax({
            type: "POST",
            url: this.redirectedUrl,
            data: { tables: JSON.stringify(tables) },
            success: function (response) {
                alert(response);
                console.log("Configuration saved successfully!");
            },
            error: function (error) {
                console.error("Error saving configuration:", error);
            }
        });
    }
};
