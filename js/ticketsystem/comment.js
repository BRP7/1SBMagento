document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('add-comment-btn').addEventListener('click', function () {
        document.getElementById('comment-form-container').style.display = 'block';
        if (!CKEDITOR.instances['comment-description']) {
            CKEDITOR.replace('comment-description', {
                height: 300
            });
        }
    });

    document.getElementById('submit-comment').addEventListener('click', function () {
        var form = document.getElementById('comment-form');
        var formKey = form.querySelector('[name="form_key"]').value;
        var formData = {
            title: form.querySelector('[name="title"]').value,
            ticketid: form.querySelector('[name="ticketid"]').value,
            userid: form.querySelector('[name="userid"]').value,
            description: CKEDITOR.instances['comment-description'].getData(),
            form_key: formKey
        };

        var url = form.getAttribute('data-url');

        new Ajax.Request(url, {
            method: 'post',
            parameters: formData,
            onSuccess: function (response) {
                var result = response.responseJSON;
                if (result.status === 'success') {
                    alert('Comment added successfully!');
                    form.reset();
                    document.getElementById('comment-form-container').style.display = 'none';
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].destroy(true);
                    }

                    var commentsTableBody = document.querySelector('#comments-table tbody');
                    commentsTableBody.innerHTML = '';

                    result.comments.forEach(function (comment) {
                        var newRow = '<tr><td>' + comment.title + '</td><td>' + comment.description + '</td><td>' + comment.created_at + '</td></tr>';
                        commentsTableBody.insertAdjacentHTML('beforeend', newRow);
                    });

                    if (!CKEDITOR.instances['comment-description']) {
                        CKEDITOR.replace('comment-description', {
                            height: 300
                        });
                    }
                } else {
                    alert('An error occurred: ' + result.message);
                }
            },
            onFailure: function () {
                alert('An error occurred while submitting the comment.');
            }
        });
    });
});
