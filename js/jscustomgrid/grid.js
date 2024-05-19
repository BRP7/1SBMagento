jQuery.noConflict();
// var url="";

function updateCustomAttribute(productId, value, url, fromId) {
    // console.log(url);
    url = url; 
    new Ajax.Request(url, {
        method: 'post',
        parameters: { id: productId, value: value, from_id: fromId },
        onSuccess: function(transport) {
            var response = transport.responseText.evalJSON();
            if (response.success) {
                alert('Custom attribute updated successfully!');
            } else {
                alert('Failed to update custom attribute');
            }
        },
        onFailure: function() {
            alert('Error while updating custom attribute');
        }
    });
}

// document.observe("dom:loaded", function() {
//     console.log(updateUrl);
//     $$('.product-name').each(function(element) {
//         element.observe('click', function() {
//             var productId = element.readAttribute('data-product-id');
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



jQuery(document).ready(function($) {
    $('.product-name').each(function(index) {
        $(this).click(function() {
            // var productId = $(this).data('id');
                    var index = $(this).closest('tr').index(); // Get the index of the clicked row
                    var productId = productIds[index]; // Access the corresponding product ID from the array
                    var updateUrl = window.updateUrl;
                    var formKey = window.formKey;
                    
                    console.log(productId);
                    console.log(updateUrl);
                    console.log(formKey);
                    
          
            // Add additional console logs or alerts to debug further
            
            $.ajax({
                url: updateUrl,
                method: 'post',
                data: { id: productId },
                success: function(response) {
                    var product = $.parseJSON(response);
                    var modalHtml = '<div id="productModal" title="Product Details">' +
                                    '<p>Name: ' + product.name + '</p>' +
                                    '<p>Custom Attribute: ' + product.custom_attribute + '</p>' +
                                    '</div>';
                    $('body').append(modalHtml);
                    $('#productModal').dialog({
                        modal: true,
                        buttons: {
                            Ok: function() {
                                $(this).dialog('close');
                                $('#productModal').remove();
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                }
            });
        });
    });
});
