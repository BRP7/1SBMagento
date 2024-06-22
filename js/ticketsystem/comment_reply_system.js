var j = jQuery.noConflict();
j(document).ready(function() {
    // Level management
    var level = 1;

    // Add Reply button click event
    j('#dynamicTable').on('click', '.add-reply', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
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
            `);
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
            `);
            newRow.append(newTd);
            j('#dynamicTable').append(newRow);
            currentTd.attr('rowspan', currentRowSpan + 1);
        }

        // Update rowspan of all the parent TDs recursively
        var parentTd = currentTd;
        while (parentTd.length) {
            var rowspan = parseInt(parentTd.attr('rowspan')) || 1;
            parentTd.attr('rowspan', rowspan + 1);
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(currentTd.index());
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
        j.ajax({
            url: saveUrl,
            type: 'POST',
            data: { text: textarea.val(), status: 'current', level: level },
            success: function(response) {
                textarea.replaceWith('<div>' + textarea.val() + '</div>');
                currentTd.find('.save').remove();
            }
        });
    });

    // Remove button click event
    j('#dynamicTable').on('click', '.remove', function() {
        var currentTd = j(this).closest('td');
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
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(firstTd.index());
        }
    });

    // Lock button click event
    j('#dynamicTable').on('click', '.lock', function() {
        var allSaved = true;
        j('#dynamicTable td').each(function() {
            if (j(this).find('textarea').length) {
                allSaved = false;
            }
        });

        if (!allSaved) {
            alert('All fields must be saved before locking.');
            return;
        }

        j('#dynamicTable td').each(function() {
            if (j(this).find('div').length) {
                j(this).append(`
                    <button class="add-reply">Add Reply</button>
                    <button class="continue">Continue</button>
                `);
            }
        });

        // Remove lock button after locking
        j(this).remove();
    });
});
