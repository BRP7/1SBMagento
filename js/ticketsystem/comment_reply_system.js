var j = jQuery.noConflict();
j(document).ready(function() {
    // Initialize maxLevels array to ensure it contains numeric values
    var maxLevels = [];

    j('#dynamicTable').on('click', '.add-reply', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
        var nextTd = currentTd.next('td');
        var currentRowSpan = parseInt(currentTd.attr('rowspan')) || 1;

        // Hide the complete button when Add Reply is clicked
        currentTd.find('.complete').hide();

        if (nextTd.length === 0) {
            // If no TD exists beside, create a new TD in the next column
            var newTd = j('<td></td>').html(`
                <div>
                    <textarea></textarea>
                    <button class="save">Save</button>
                    <button class="remove">Remove</button>
                </div>
            `).attr('data-parent-td', currentTdIndex);

            // Determine the correct level for this column
            var level = (maxLevels[currentTdIndex + 1] || 0) + 1;
            newTd.attr('data-level', level);
            maxLevels[currentTdIndex + 1] = level;

            currentRow.append(newTd);

            // Add lock button in the last row
            var lastRow = j('#dynamicTable tr:last');
            if (lastRow.find('.lock').length === 0) {
                lastRow.append('<td><button class="lock">Lock</button></td>');
            }
        } else {
            // If TD exists beside, create a new row and add TD to it
            var newRow = j('<tr></tr>');
            var newTd = j('<td></td>').html(`
                <div>
                    <textarea></textarea>
                    <button class="save">Save</button>
                    <button class="remove">Remove</button>
                </div>
            `).attr('data-parent-td', currentTdIndex);

            // Determine the correct level for this column
            var level = (maxLevels[currentTdIndex + 1] || 0) + 1;
            newTd.attr('data-level', level);
            maxLevels[currentTdIndex + 1] = level;

            newRow.append(newTd);
            currentRow.after(newRow);
            currentTd.attr('rowspan', currentRowSpan + 1);
        }

        // Update rowspan of all the parent TDs recursively
        var parentTd = currentTd;
        while (parentTd.length) {
            var rowspan = parseInt(parentTd.attr('rowspan')) || 1;
            parentTd.attr('rowspan', rowspan + 1);
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(currentTdIndex);
        }
    });

    // Complete button click event
    j('#dynamicTable').on('click', '.complete', function() {
        var currentTd = j(this).closest('td');
        j.ajax({
            url: 'path_to_your_controller',
            type: 'POST',
            data: { status: 'complete' },
            success: function(response) {
                currentTd.find('.complete').remove();
                currentTd.find('.add-reply').hide();
                var nextTd = j('<td></td>').html('<div>Complete</div>');
                currentTd.after(nextTd);
            }
        });
    });

    // Save button click event
    j('#dynamicTable').on('click', '.save', function() {
        var currentTd = j(this).closest('td');
        var textarea = currentTd.find('textarea');
        var saveUrl = j('#dynamicTable').data('url');
        var formKey = FORM_KEY;
        j.ajax({
            url: saveUrl,
            type: 'POST',
            data: { text: textarea.val(), status: 'current', level: currentTd.data('level'), form_key: formKey },
            success: function(response) {
                textarea.replaceWith('<div>' + textarea.val() + '</div>');
                currentTd.find('.save, .remove').remove();
            }
        });
    });

    // Remove button click event
    j('#dynamicTable').on('click', '.remove', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
        currentTd.remove();

        // Update rowspan of the first TD if needed
        var firstTd = j('#dynamicTable td:first');
        var currentRowSpan = parseInt(firstTd.attr('rowspan')) || 1;
        if (currentRowSpan > 1) {
            firstTd.attr('rowspan', currentRowSpan - 1);
        }

        // Update rowspan of all the parent TDs recursively
        var parentTd = firstTd;
        while (parentTd.length) {
            var rowspan = parseInt(parentTd.attr('rowspan')) || 1;
            if (rowspan > 1) {
                parentTd.attr('rowspan', rowspan - 1);
            }
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(currentTdIndex);
        }
    });

    // Lock button click event
    j('#dynamicTable').on('click', '.lock', function() {
        console.log('Lock button clicked'); // Debug statement
        var allSaved = true;
        var maxLevel = Math.max.apply(null, maxLevels.filter(function(n) { return !isNaN(n); })); // Get the maximum level

        console.log('Max level:', maxLevel); // Debug statement

        // Check only the fields at the maximum level
        j('#dynamicTable td[data-level=' + maxLevel + ']').each(function() {
            if (j(this).find('textarea').length) {
                allSaved = false;
            }
        });

        if (!allSaved) {
            alert('All fields must be saved before locking.');
            return;
        }

        // Ensure all td elements in the same column as the max-level td have the same max level
        j('#dynamicTable td[data-level=' + maxLevel + ']').each(function() {
            var colIndex = j(this).index();
            j('#dynamicTable tr').each(function() {
                var tdInSameColumn = j(this).find('td').eq(colIndex);
                if (tdInSameColumn.find('div').length) {
                    tdInSameColumn.attr('data-level', maxLevel); // Ensure same max level
                    tdInSameColumn.append(`
                        <button class="add-reply">Add Reply</button>
                        <button class="complete">Complete</button>
                    `);
                }
            });
        });

        // Remove lock button after locking
        console.log('Removing lock button'); // Debug statement
        j(this).remove();
    });
});
