var CommentSystem = Class.create({
    initialize: function (config) {
        this.container = $(config.containerId);
        this.addInitialCommentButton = $(config.addInitialCommentButtonId);
        this.saveUrl = config.saveUrl;
        this.addInitialCommentButton.observe('click', this.addInitialComment.bind(this));
        this.container.observe('click', this.handleCommentActions.bind(this));
    },

    handleCommentActions: function (e) {
        var self = this;
        if (e.target && e.target.hasClassName('add-new')) {
            let parentComment = e.target.up('.comment');
            console.log(parentComment); // Log the entire element
            let parentId = parentComment.readAttribute('data-comment-id');
            let ticketId = parentComment.readAttribute('data-ticket-id');
            console.log('parentId:', parentId); // Log the parent comment ID
            console.log('ticketId:', ticketId); // Log the ticket ID
            let newCommentBox = this.createCommentBox(parentId, true);
            newCommentBox.writeAttribute('data-ticket-id', ticketId); // Set the ticket ID for the new comment box
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
            console.log(commentBox); // Log the entire comment box
            console.log('parentId:', parentId); // Log the parent comment ID
            console.log('commentId:', commentId); // Log the comment ID
            console.log('ticketId:', ticketId); // Log the ticket ID
    
            this.saveComment(commentData, parentId, commentId, ticketId, this.saveUrl, function (response) {
                if (response.success && !commentId) {
                    commentBox.writeAttribute('data-comment-id', response.comment_id);
                }
                alert('Comment saved!');
            });
        }
    }
    ,

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
        return commentBox;
    },
    

    // saveComment: function (comment, parentId, commentId, callback) {
    //     console.log({ comment: comment, parent_id: parentId, comment_id: commentId });
    //     // new Ajax.Request(this.saveUrl, {
    //     //     method: 'post',
    //     //     contentType: 'application/json',
    //     //     postBody: JSON.stringify({ comment: comment, parent_id: parentId, comment_id: commentId }),
    //     //     onSuccess: function(response) {
    //     //         callback(JSON.parse(response.responseText));
    //     //     }
    //     // });

    //     new Ajax.Request(this.saveUrl, {
    //         method: 'post',
    //         parameters: {
    //             comment: comment,
    //             parent_id: parentId,
    //             comment_id: commentId
    //         },
    //         onSuccess: function (response) {
    //             var result = response.responseText.evalJSON();
    //             console.log(result);
    //             if (result.status === 'success') {
    //                 alert("Reply Saved successfully");
    //                 // element.update(newValue);
    //                 // element.removeClassName("editing");
    //             } else {
    //                 alert(result.message);
    //             }
    //         },
    //         onFailure: function () {
    //             alert('An error occurred while renaming the file.');
    //         }
    //     });
    // },

    saveComment: function (comment, parentId, commentId, ticketId, url, callback) {
        new Ajax.Request(url, {
            method: 'post',
            parameters: {
                form_key: FORM_KEY,
                comment: comment,
                parent_id: parentId,
                comment_id: commentId,
                ticket_id: ticketId,
            },
            onSuccess: function (response) {
                callback(response);
                var result = response.responseText.evalJSON();
                console.log(result);
                if (result.status === 'success') {
                    alert("Reply saved successfully");
                } else {
                    alert("Error: " + result.message);
                }
            },
            onFailure: function () {
                alert('An error occurred while saving the comment.');
            }
        });
    }
    ,
    

    addInitialComment: function () {
        let newCommentBox = this.createCommentBox(0, false);
        this.container.insert(newCommentBox);
        CKEDITOR.replace(newCommentBox.down('textarea'));
        this.addInitialCommentButton.hide();
    }
});
