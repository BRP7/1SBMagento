var CommentSystem = Class.create({
    initialize: function (config) {
        this.container = $(config.containerId);
        this.saveUrl = config.saveUrl;
        // this.addInitialCommentButton.observe('click', this.addInitialComment.bind(this));
        this.container.observe('click', this.handleCommentActions.bind(this));
    },

    handleCommentActions: function (e) {
        if (e.target && e.target.hasClassName('add-new')) {
            let parentComment = e.target.up('.comment');
            let grandParentElement = parentComment.up('tr.comment');

            if (grandParentElement) {
                console.log(grandParentElement.down('td').down('.comment-content .add-new'));
                grandParentElement.down('td').down('.comment-content .add-new').remove();
                // grandParentElement.remove(); 
            }
            let parentId = parentComment.readAttribute('data-comment-id');
            let ticketId = parentComment.readAttribute('data-ticket-id');
            let newCommentBox = this.createCommentBox(parentId, false);
            // if($$(".children"))
            // console.log($$(".children")[0]);
            // parentComment.down('.add-new').remove();
            newCommentBox.writeAttribute('data-ticket-id', ticketId);
            parentComment.down('.children').insert(newCommentBox);
            CKEDITOR.replace(newCommentBox.down('textarea'));
        } else if (e.target && e.target.hasClassName('save')) {
            let commentBox = e.target.up('.comment');
            let textBox = commentBox.down('textarea');
            let editorInstance = CKEDITOR.instances[textBox.identify()];
            let commentData = editorInstance.getData();
            let parentId = commentBox.readAttribute('data-parent-id');
            let commentId = commentBox.readAttribute('data-comment-id');
            let ticketId = commentBox.readAttribute('data-ticket-id');

            this.saveComment(commentData, parentId, commentId, ticketId, function (response) {
                if (!commentId) {
                    commentBox.writeAttribute('data-comment-id', response.comment_id);
                }
                commentBox.down('.comment-content').update(`<div>${commentData}</div><button class="add-new">Add New</button>`);
                commentBox.down('.comment-content').removeChild(textBox.up());
            });
        }
    },

    createCommentBox: function (parentId, includeAddNewButton) {
        let commentId = 'comment-' + new Date().getTime();
        let commentBox = new Element('tr', { 'class': 'comment', 'data-parent-id': parentId, 'data-comment-id': '', 'data-ticket-id': this.container.readAttribute('data-ticket-id') });
        let buttonsHtml = `<button class="save">Save</button>`;
        if (includeAddNewButton) {
            buttonsHtml += `<button class="add-new">Add New</button>`;
        }
        commentBox.update(`
            <td>
                <div class="comment-content">
                    <textarea id="${commentId}" placeholder="Enter your comment"></textarea>
                    ${buttonsHtml}
                </div>
                <table class="children"></table>
            </td>
        `);
        // console.log(parentComment.up('.comment'));
        return commentBox;
    },

    saveComment: function (comment, parentId, commentId, ticketId, callback) {
        new Ajax.Request(this.saveUrl, {
            method: 'post',
            parameters: {
                form_key: FORM_KEY,
                comment: comment,
                parent_id: parentId,
                comment_id: commentId,
                ticket_id: ticketId
            },
            onSuccess: function (response) {
                var result;
                try {
                    result = response.responseText.evalJSON();
                } catch (e) {
                    alert('Invalid server response.');
                    return;
                }

                console.log(result);
                if (result.status === 'success') {
                    callback(result);
                } else {
                    alert("Error: " + (result.message || 'Unknown error'));
                }
            },
            onFailure: function () {
                alert('An error occurred while saving the comment.');
            }
        });
    },

    // addInitialComment: function() {
    //     let newCommentBox = this.createCommentBox(0, false);
    //     this.container.insert(newCommentBox);
    //     CKEDITOR.replace(newCommentBox.down('textarea'));
    //     this.addInitialCommentButton.hide();
    // }
});
