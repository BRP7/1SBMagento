var j = jQuery.noConflict();
var ApplyFilter = Class.create({
    initialize: function ( redirectUrl, formKey) {
     
        this.redirectUrl = redirectUrl;
        this.formKey = formKey;
    
    },
    applyFilter:function name(element) {
        // console.log(this.redirectUrl);
        let label = element.innerHTML;
        new Ajax.Request(this.redirectUrl, {
            method: 'post',
            parameters: {'label' : label},
            onSuccess: function (response) {
                var result = response.responseJSON;
                if (result.status === 'success') {
                    alert('filter applied successfully!');       
                } else {
                    alert('An error occurred: ' + result.message);
                }
            },
            onFailure: function () {
                alert('An error occurred while submitting the comment.');
            }
        });
    }

})