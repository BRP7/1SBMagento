
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-comment-btn').addEventListener('click', function() {
        document.getElementById('comment-form-container').style.display = 'block';
        CKEDITOR.replace('comment-description', {
            height: 300
        });
    });

    // document.getElementById('submit-comment').addEventListener('click', function(event) {
    //     event.preventDefault();
    //     for (var instance in CKEDITOR.instances) {
    //         CKEDITOR.instances[instance].updateElement();
    //     }

    //     var form = document.getElementById('comment-form');
    //     var formData = new FormData(form);

    //     new Ajax.Request(form.action, {
    //         method: 'post',
    //         parameters: formData,
    //         onSuccess: function(response) {
    //             alert('Comment added successfully!');
    //             form.reset();
    //             document.getElementById('comment-form-container').style.display = 'none';
    //             for (var instance in CKEDITOR.instances) {
    //                 CKEDITOR.instances[instance].destroy(true);
    //             }
    //         },
    //         onFailure: function() {
    //             alert('An error occurred while submitting the comment.');
    //         }
    //     });
    // });

    $('submit-comment').observe('click',function(){
        var formKey=FROM_KEY;
        var form = document.getElementById('comment-form');
        var formData = new FormData(form);
        formData.append("title");
        formData.append("description");
        formData.append("form_key",formKey);
        var url = $('submit-comment').getAttribute('data-url');
        console.log(url);
        new Ajax.Request(url, {
            method: 'post',
            parameters: formData,
            onSuccess: function(response) {
                alert('Comment added successfully!');
                form.reset();
                document.getElementById('comment-form-container').style.display = 'none';
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].destroy(true);
                }
            },
            onFailure: function() {
                alert('An error occurred while submitting the comment.');
            }
        });
    });
    });
