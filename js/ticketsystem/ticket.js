var j = jQuery.noConflict();
document.addEventListener("DOMContentLoaded", function () {
    CKEDITOR.replace('description');
    function showPopup() {
        var popup = document.getElementById('form-popup');
        popup.style.display = 'block';
        popup.style.position = 'absolute';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.background = '#fff';
        popup.style.padding = '20px';
        popup.style.border = '1px solid #ccc';
        popup.style.zIndex = 1000;

        var overlay = document.createElement('div');
        overlay.id = 'overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = 0;
        overlay.style.left = 0;
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.background = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = 999;
        document.body.appendChild(overlay);
    }
    function hidePopup() {
        var popup = document.getElementById('form-popup');
        popup.style.display = 'none';
        var overlay = document.getElementById('overlay');
        if (overlay) {
            overlay.remove();
        }
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].destroy();
        }
    }
    document.getElementById('open-form-popup').addEventListener('click', function () {
        showPopup();
    });
    document.addEventListener('click', function (event) {
        if (event.target.id === 'overlay') {
            hidePopup();
        }
    });
    document.getElementById('submit-form').addEventListener('click', function () {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var form = document.getElementById('popup-form');
        form.submit();
        hidePopup();
    });
});

