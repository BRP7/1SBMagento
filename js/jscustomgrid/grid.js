jQuery.noConflict();
// var url="";

function updateCustomAttribute(productId, value, url, fromId) {
    // console.log(url);
    url = url;
    new Ajax.Request(url, {
        method: 'post',
        parameters: { id: productId, value: value, from_id: fromId },
        onSuccess: function (transport) {
            var response = transport.responseText.evalJSON();
            if (response.success) {
                alert('Custom attribute updated successfully!');
            } else {
                alert('Failed to update custom attribute');
            }
        },
        onFailure: function () {
            alert('Error while updating custom attribute');
        }
    });
}

// document.observe("dom:loaded", function() {
//     console.log(updateUrl);
//     $$('.product-name').each(function(element) {
//         element.observe('click', function() {
            // var productId = element.readAttribute('data-product-id');
//             console.log(productId);
//             new Ajax.Request(updateUrl, {
//                 method: 'post',
//                 parameters: { id: productId, form_key: formKey },
//                 onSuccess: function(response) {
//                     var product = response.responseText.evalJSON();
//                     var modalHtml = '<div id="productModal" title="Product Details">' +
//                                     '<p>Name: ' + product.name + '</p>' +
//                                     '<p>Custom Attribute: ' + product.custom_attribute + '</p>' +
//                                     '</div>';
//                     $$('body')[0].insert({ bottom: modalHtml });
//                     $('productModal').dialog({
//                         modal: true,
//                         buttons: {
//                             Ok: function() {
//                                 $(this).dialog('close');
//                                 $('productModal').remove();
//                             }
//                         }
//                     });
//                 }
//             });
//         });
//     });
// });


// jQuery(document).ready(function($) {

//     $('.product-name').each(function() {
//         $(this).click(function() {
//              var productId = $(this).data('product-id');
//         var updateUrl = $(this).data('update-url');
//         var formKey = $(this).data('form-key');

//         console.log(productId);
//         console.log(updateUrl);
//         console.log(formKey);// Accessing formKey variable directly

//             $.ajax({
//                 url: updateUrl,
//                 method: 'post',
//                 data: { id: productId },
//                 success: function(response) {
//                     var product = $.parseJSON(response);
//                     var modalHtml = '<div id="productModal" title="Product Details">' +
//                                     '<p>Name: ' + product.name + '</p>' +
//                                     '<p>Custom Attribute: ' + product.custom_attribute + '</p>' +
//                                     '</div>';
//                     $('body').append(modalHtml);
//                     $('#productModal').dialog({
//                         modal: true,
//                         buttons: {
//                             Ok: function() {
//                                 $(this).dialog('close');
//                                 $('#productModal').remove();
//                             }
//                         }
//                     });
//                 }
//             });
//         });
//     });
// });



// jQuery(document).ready(function($) {
//     $('.product-name').each(function(index) {
//         $(this).click(function() {
//             // var productId = $(this).data('id');
//                     var index = $(this).closest('tr').index(); // Get the index of the clicked row
//                     var productId = productIds[index]; // Access the corresponding product ID from the array
//                     var updateUrl = window.updateUrl;
//                     var formKey = window.formKey;

//                     console.log(productId);
//                     console.log(updateUrl);
//                     console.log(formKey);


//             // Add additional console logs or alerts to debug further

//             $.ajax({
//                 url: updateUrl,
//                 method: 'post',
//                 data: { id: productId },
//                 success: function(response) {
//                     var product = $.parseJSON(response);
//                     var modalHtml = '<div id="productModal" title="Product Details">' +
//                                     '<p>Name: ' + product.name + '</p>' +
//                                     '<p>Custom Attribute: ' + product.custom_attribute + '</p>' +
//                                     '</div>';
//                     $('body').append(modalHtml);
//                     $('#productModal').dialog({
//                         modal: true,
//                         buttons: {
//                             Ok: function() {
//                                 $(this).dialog('close');
//                                 $('#productModal').remove();
//                             }
//                         }
//                     });
//                 },
//                 error: function(xhr, status, error) {
//                     console.log(xhr.responseText);
//                     console.log(status);
//                     console.log(error);
//                 }
//             });
//         });
//     });
// });


jQuery(document).ready(function ($) {
    $('.product-name').each(function (index) {
        $(this).click(function () {

            var productId = $(this).data('product-id');
            var updateUrl = $(this).data('update-url');
            var formKey = $(this).data('form-key');
    
            // var productId = productIds[index]; // Access the corresponding product ID from the array
            // var updateUrl = window.updateUrl;
            // var formKey = window.formKey;

            console.log(productId);
            console.log(updateUrl);
            console.log(formKey);

            $.ajax({
                url: updateUrl,
                method: 'post',
                data: { id: productId, from_id: formKey },
                success: function(response) {
                    console.log(response);
                    var product = $.parseJSON(response);
                    var modalHtml = '<div id="productModal" title="Product Details">' +
                                    '<p>Name: ' + product.name + '</p>' +
                                    '<p>Brand: ' + product.brand + '</p>' +
                                    '<p>Color: ' + product.color + '</p>' +
                                    '<p>Price: ' + product.price + '</p>' +
                                    '<p>Custom Attribute: ' + product.custom_select_attribute + '</p>' +
                                    '</div>';
                    $('body').append(modalHtml);
                
                    // Open modal dialog using simple jQuery
                    var $productModal = $('#productModal');
                    $productModal.css({
                        'position': 'fixed',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)',
                        'background': '#fff',
                        'border': '1px solid #000',
                        'padding': '20px',
                        'box-shadow': '0 0 10px rgba(0,0,0,0.3)',
                        'z-index': '9999'
                    }).show();
                
                    // Close modal dialog after 2 seconds
                    setTimeout(function() {
                        $productModal.hide().remove();
                    }, 3000);
                },
                
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                }
            });
        });
    });
});

// $('#productModal').click(function () {
//     $(this).hide().remove();
// });