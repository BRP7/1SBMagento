var j = jQuery.noConflict();
document.observe("dom:loaded", function() {
    var editorSettings = {
        mode: 'textareas',
        editor_selector: 'magento',
        // plugins: 'advlist autolink lists link image charmap print preview anchor textcolor',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
    };
    tinyMCE.init(editorSettings);
    function showPopup() {
        var popup = $('form-popup');
        popup.setStyle({
            display: 'block',
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            background: '#fff',
            padding: '20px',
            border: '1px solid #ccc',
            zIndex: 1000
        });
        var overlay = new Element('div', { 'id': 'overlay' }).setStyle({
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            background: 'rgba(0, 0, 0, 0.5)',
            zIndex: 999
        });
        document.body.appendChild(overlay);
    }
    function hidePopup() {
        var popup = $('form-popup');
        popup.setStyle({ display: 'none' });
        if ($('overlay')) {
            $('overlay').remove();
        }
    }
    $('open-form-popup').observe('click', function() {
        showPopup();
    });
    document.observe('click', function(event) {
        if (event.findElement('#overlay')) {
            hidePopup();
        }
    });
    document.getElementById('submit-form').addEventListener("click",function(){
        var form = $('popup-form');
        form.submit();
        hidePopup();
    })
});