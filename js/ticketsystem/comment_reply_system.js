var CommentSystem = Class.create({
    initialize: function(config) {
        this.container = $(config.containerId);
        this.addInitialCommentButton = $(config.addInitialCommentButtonId);
        this.saveUrl = config.saveUrl;

        this.addInitialCommentButton.observe('click', this.addInitialComment.bind(this));
        this.container.observe('click', this.handleCommentActions.bind(this));
    },

    handleCommentActions: function(e) {
        if (e.target && e.target.hasClassName('add-new')) {
            let parentComment = e.target.up('.comment');
            let parentId = parentComment.readAttribute('data-comment-id');
            let newCommentBox = this.createCommentBox(parentId, true);
            parentComment.down('.children').insert(newCommentBox);
            CKEDITOR.replace(newCommentBox.down('textarea'));
        } else if (e.target && e.target.hasClassName('save')) {
            let commentBox = e.target.up('.comment');
            let textBox = commentBox.down('textarea');
            let editorInstance = CKEDITOR.instances[textBox.identify()];
            let commentData = editorInstance.getData();
            let parentId = commentBox.readAttribute('data-parent-id');
            let commentId = commentBox.readAttribute('data-comment-id');

            this.saveComment(commentData, parentId, commentId, function(response) {
                if (response.success && !commentId) {
                    commentBox.writeAttribute('data-comment-id', response.comment_id);
                }
                alert('Comment saved!');
            });
        }
    },

    createCommentBox: function(parentId, includeAddNewButton) {
        let commentId = 'comment-' + new Date().getTime();
        let commentBox = new Element('tr', { 'class': 'comment', 'data-parent-id': parentId, 'data-comment-id': '' });
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

    saveComment: function(comment, parentId, commentId, callback) {
        new Ajax.Request(this.saveUrl, {
            method: 'post',
            contentType: 'application/json',
            postBody: JSON.stringify({ comment: comment, parent_id: parentId, comment_id: commentId }),
            onSuccess: function(response) {
                callback(JSON.parse(response.responseText));
            }
        });
    },

    addInitialComment: function() {
        let newCommentBox = this.createCommentBox(0, false);
        this.container.insert(newCommentBox);
        CKEDITOR.replace(newCommentBox.down('textarea'));
        this.addInitialCommentButton.hide();
    }
});
