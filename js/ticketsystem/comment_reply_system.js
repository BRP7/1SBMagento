var j = jQuery.noConflict();
j(document).ready(function() {
    var level = 1; 

    j('#dynamicTable').on('click', '.add-reply', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
        var nextTd = currentTd.next('td');
        var currentRowSpan = parseInt(currentTd.attr('rowspan')) || 1;

        currentTd.find('.complete').hide();

        if (nextTd.length === 0) {
            var newTd = j('<td></td>').html(`
                <div>
                    <textarea></textarea>
                    <button class="save">Save</button>
                    <button class="remove">Remove</button>
                </div>
            `).attr('data-level', level).attr('data-parent-td', currentTdIndex); 
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
            `).attr('data-level', level).attr('data-parent-td', currentTdIndex); 
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

        level++;
    });

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

    j('#dynamicTable').on('click', '.remove', function() {
        var currentTd = j(this).closest('td');
        var currentRow = j(this).closest('tr');
        var currentTdIndex = currentTd.index();
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
        var allSaved = true;
        var currentLevel = level - 1; 

        j('#dynamicTable td[data-level=' + currentLevel + ']').each(function() {
            if (j(this).find('textarea').length) {
                allSaved = false;
            }
        });

        if (!allSaved) {
            alert('All fields must be saved before locking.');
            return;
        }

        j('#dynamicTable td[data-level=' + currentLevel + ']').each(function() {
            if (j(this).find('div').length) {
                j(this).append(`
                    <button class="add-reply">Add Reply</button>
                    <button class="complete">Complete</button>
                `);
            }
        });

        j(this).remove();
    });
});
