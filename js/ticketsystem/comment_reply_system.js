var CommentBox = Class.create({
    initialize: function (saveredirectUrl, formKey, loadredirectUrl) {
        this.saveredirectUrl = saveredirectUrl
        this.loadredirectUrl = loadredirectUrl
        this.formKey = formKey
        this.level = parseInt($$('.commentTable')[0].getAttribute('data-level')) + 1;
        this.ticketId = $$('.commentTable')[0].getAttribute('data-ticket-id');
        this.addLockButtonToLastRow();
    },
    addNewRow: function (event) {
        if (!(event instanceof HTMLElement)) {
            var event = event.element()
        }
        if (event.nextElementSibling) {
            this.removeButton(event.nextElementSibling);
        }
        let td = event.up('td');
        let tr = td.up('tr');
        let tbody = tr.up('tbody');
        this.parentId = td.getAttribute('data-comment-id');
        let existingTds = tr.select(`td[data-level="${parseInt(this.level)}"]`);
        if (existingTds.length === 0) {
            let newTd = new Element('td', {
                'data-level': this.level,
                'data-parent-id': this.parentId,
                'rowspan': 1
            });
            let textarea = new Element('textarea');
            let saveBtn = this.createButton('Save', this.saveRow.bind(this));
            newTd.insert(textarea);
            newTd.insert(saveBtn);
            tr.insert(newTd);
        } else {
            let newTr = new Element('tr');
            let newTd = new Element('td', {
                'data-level': this.level,
                'data-parent-id': this.parentId,
                'rowspan': 1
            });
            let textarea = new Element('textarea');
            let saveBtn = this.createButton('Save', this.saveRow.bind(this));
            newTd.insert(textarea);
            newTd.insert(saveBtn);
            newTr.insert(newTd);
            if (tr.nextSibling) {
                tbody.insertBefore(newTr, tr.nextSibling);
            } else {
                tbody.insert(newTr);
            }
            this.updateRowspan(td, 1);
        }
        this.addLockButtonToLastRow();
        console.log($$('.commentTable')[0])
    },
    saveRow: function (element) {
        let saveBtn = element.element()
        let td = saveBtn.up('td')
        let textarea = saveBtn.previousElementSibling
        let value = textarea.value
        var valueSpan = new Element('span').update(value);
        td.update(valueSpan)
        this.saveDataToDb(td, value);
        textarea.remove();
        saveBtn.remove();
    },
    saveDataToDb: function (td, data) {
        let parentId = td.getAttribute('data-parent-id');
        let level = td.getAttribute('data-level');
        new Ajax.Request(this.saveredirectUrl, {
            method: 'post',
            parameters: {
                parentId: parentId,
                level: level,
                data: data,
                ticketId: this.ticketId,
                formKey: this.formKey,
            },
            onSuccess: function (response) {
                alert('data save successfully')
                td.setAttribute('data-comment-id', response.responseText);
            },
            onFailure: function () {
                console.error('Failed to save data.');
            }
        });
    },
    removeButton: function (btn) {
        btn.remove()
    },
    addLockButtonToLastRow: function () {
        console.log(12);
        let table = $$('table.commentTable')[0];
        let tbody = table.down('tbody');
        let existingLockButtonRow = $$('.lock-button-row')[0];
        if (existingLockButtonRow) {
            existingLockButtonRow.remove();
        }
        let newRow = new Element('tr', { 'class': 'lock-button-row' });
        for (let i = 0; i < this.level; i++) {
            let td = new Element('td');
            newRow.insert(td);
        }
        let lockTd = new Element('td');
        let lockBtn = this.createButton('Lock', this.lockLevel.bind(this), 'lock-button');
        lockTd.insert(lockBtn);
        newRow.insert(lockTd);
        tbody.insert(newRow);
    },
    updateRowspan: function (td, increment) {
        let commentId = td.getAttribute('data-comment-id');
        let parentId = td.getAttribute('data-parent-id');
        let currentRowspan = parseInt(td.getAttribute('rowspan')) || 1;
        td.setAttribute('rowspan', currentRowspan + increment);
        let parentTds = $$(`td[data-comment-id="${parentId}"]`);
        parentTds.forEach(parentTd => {
            this.updateRowspan(parentTd, increment);
        });
    },
    getPreviousTd: function (td, level) {
        let tr = td.up('tr').previous();
        while (tr) {
            let previousTd = tr.select(`td[data-level="${level}"]`)[0];
            if (previousTd) return previousTd;
            tr = tr.previous();
        }
        return null;
    },
    createButton: function (label, callback, btnClass) {
        btnClass = btnClass || 'button';
        let button = new Element('button', { className: btnClass }).update(label);
        button.observe('click', callback);
        return button;
    },
    completeRow: function (event) {
        if (!(event instanceof HTMLElement)) {
            var event = event.element()
        }
        let td = event.up('td');
        if (td.select('textarea')[0]) {
            td.select('textarea')[0].hide();
        }
        if (td.select('button')) {
            td.select('button').invoke('hide');
        }
    },
    lockLevel: function (event) {
        let currTds = $$('td[data-level="' + (this.level) + '"]');
        currTds.each(function (td) {
            if (td.select('textarea').length > 0) {
                td.up('tr').remove();
            }
        })
        this.loadComments();
    },
    loadComments: function () {
        var params = {
            formKey: this.formKey,
        }
        new Ajax.Request(this.loadredirectUrl, {
            method: 'post',
            parameters: params,
            onSuccess: function (response) {
                $('comment_replay').update(response.responseText);
                this.addLockButtonToLastRow();
            },
            onFailure: function () {
                console.log('Error saving report.');
            }
        });
    }
});
