function updateCustomAttribute(productId, value, url, fromId) {
    console.log(url);
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

document.observe("dom:loaded", function() {
    $$('.product-name').each(function(element) {
        element.observe('click', function() {
            var productId = element.readAttribute('data-product-id');
            new Ajax.Request(url, {
                method: 'post',
                parameters: { id: productId },
                onSuccess: function(response) {
                    var product = response.responseText.evalJSON();
                    var modalHtml = '<div id="productModal" title="Product Details">' +
                                    '<p>Name: ' + product.name + '</p>' +
                                    '<p>Custom Attribute: ' + product.custom_attribute + '</p>' +
                                    '</div>';
                    $$('body')[0].insert({ bottom: modalHtml });
                    $('productModal').dialog({
                        modal: true,
                        buttons: {
                            Ok: function() {
                                $(this).dialog('close');
                                $('productModal').remove();
                            }
                        }
                    });
                }
            });
        });
    });
});
