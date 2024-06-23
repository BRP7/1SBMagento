var j = jQuery.noConflict();
j(document).ready(function() {
    var maxLevels = [];

    j('#dynamicTable').on('click', '.add-reply', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
        var nextTd = currentTd.next('td');
        var currentRowSpan = parseInt(currentTd.attr('rowspan')) || 1;

        console.log('Add Reply clicked');
        console.log('currentTdIndex:', currentTdIndex);
        console.log('currentRowSpan:', currentRowSpan);

        // Hide the complete button when Add Reply is clicked
        currentTd.find('.complete').hide();

        if (nextTd.length === 0) {
            var newTd = j('<td></td>').html(`
                <div>
                    <textarea></textarea>
                    <button class="save">Save</button>
                    <button class="remove">Remove</button>
                </div>
            `).attr('data-parent-td', currentTdIndex);

            var level = (maxLevels[currentTdIndex + 1] || 0) + 1;
            newTd.attr('data-level', level);
            maxLevels[currentTdIndex + 1] = level;

            currentRow.append(newTd);

            var lastRow = j('#dynamicTable tr:last');
            if (lastRow.find('.lock').length === 0) {
                lastRow.append('<td><button class="lock">Lock</button></td>');
            }
        } else {
            var newRow = j('<tr></tr>');
            var newTd = j('<td></td>').html(`
                <div>
                    <textarea></textarea>
                    <button class="save">Save</button>
                    <button class="remove">Remove</button>
                </div>
            `).attr('data-parent-td', currentTdIndex);

            var level = (maxLevels[currentTdIndex + 1] || 0) + 1;
            newTd.attr('data-level', level);
            maxLevels[currentTdIndex + 1] = level;

            newRow.append(newTd);
            currentRow.after(newRow);
            currentTd.attr('rowspan', currentRowSpan + 1);
        }

        var parentTd = currentTd;
        while (parentTd.length) {
            var rowspan = parseInt(parentTd.attr('rowspan')) || 1;
            parentTd.attr('rowspan', rowspan + 1);
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(currentTdIndex);
        }
    });

    j('#dynamicTable').on('click', '.complete', function() {
        var currentTd = j(this).closest('td');
        console.log('Complete button clicked:', currentTd.index());

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

    j('#dynamicTable').on('click', '.save', function() {
        var currentTd = j(this).closest('td');
        var textarea = currentTd.find('textarea');
        var saveUrl = j('#dynamicTable').data('url');
        var formKey = FORM_KEY;

        console.log('Save button clicked:', currentTd.index());

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

    j('#dynamicTable').on('click', '.remove', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
        console.log('Remove button clicked:', currentTdIndex);
        
        currentTd.remove();

        var firstTd = j('#dynamicTable td:first');
        var currentRowSpan = parseInt(firstTd.attr('rowspan')) || 1;
        if (currentRowSpan > 1) {
            firstTd.attr('rowspan', currentRowSpan - 1);
        }

        var parentTd = firstTd;
        while (parentTd.length) {
            var rowspan = parseInt(parentTd.attr('rowspan')) || 1;
            if (rowspan > 1) {
                parentTd.attr('rowspan', rowspan - 1);
            }
            parentTd = parentTd.closest('tr').prev('tr').find('td').eq(currentTdIndex);
        }
    });

    j('#dynamicTable').on('click', '.lock', function() {
        console.log('Lock button clicked'); // Debug statement
        var allSaved = true;
        var maxLevel = Math.max.apply(null, maxLevels.filter(function(n) { return !isNaN(n); }));

        console.log('Max level:', maxLevel); // Debug statement

        j('#dynamicTable td[data-level=' + maxLevel + ']').each(function() {
            if (j(this).find('textarea').length) {
                allSaved = false;
            }
        });

        if (!allSaved) {
            alert('All fields must be saved before locking.');
            return;
        }

        var maxLevelColIndexes = [];
        j('#dynamicTable td[data-level=' + maxLevel + ']').each(function() {
            maxLevelColIndexes.push(j(this).index());
        });

        console.log('maxLevelColIndexes:', maxLevelColIndexes);

        maxLevelColIndexes.forEach(function(colIndex) {
            j('#dynamicTable tr').each(function() {
                var tdInSameColumn = j(this).find('td').eq(colIndex);
                if (tdInSameColumn.length && tdInSameColumn.find('div').length && !tdInSameColumn.find('.add-reply').length) {
                    tdInSameColumn.attr('data-level', maxLevel);
                    tdInSameColumn.append(`
                        <button class="add-reply">Add Reply</button>
                        <button class="complete">Complete</button>
                    `);
                }
            });
        });

        // Ensure the first td in each row also receives the buttons
        j('#dynamicTable tr').each(function() {
            var firstTd = j(this).find('td').first();
            console.log('firstTd:', firstTd.index());
            if (firstTd.length && firstTd.find('div').length && !firstTd.find('.add-reply').length) {
                firstTd.append(`
                    <button class="add-reply">Add Reply</button>
                    <button class="complete">Complete</button>
                `);
            }
        });

        console.log('Removing lock button'); // Debug statement
        j(this).remove();
    });
});
