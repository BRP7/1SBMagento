document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('comment-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('add-new')) {
            let parentComment = e.target.closest('.comment');
            let newCommentBox = createCommentBox();
            parentComment.querySelector('.children').appendChild(newCommentBox);
            CKEDITOR.replace(newCommentBox.querySelector('textarea'));
        } else if (e.target && e.target.classList.contains('save')) {
            let textBox = e.target.closest('.comment').querySelector('textarea');
            let editorInstance = CKEDITOR.instances[textBox.id];
            let commentData = editorInstance.getData();
            saveComment(commentData, function(response) {
                alert('Comment saved!');
            });
        }
    });
});

function createCommentBox() {
    let commentBox = document.createElement('tr');
    commentBox.classList.add('comment');
    commentBox.innerHTML = `
        <td>
            <div class="comment-content">
                <textarea placeholder="Enter your comment"></textarea>
                <button class="save">Save</button>
                <button class="add-new">Add New</button>
            </div>
            <table class="children"></table>
        </td>
    `;
    return commentBox;
}

function saveComment(comment, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/path-to-magento-controller');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify({ comment: comment }));
}
