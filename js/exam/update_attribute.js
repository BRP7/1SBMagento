function updateProductCustomAttribute(productId, attributeName, attributeValue) {
    new Ajax.Request('/update_attribute.php', {
        method: 'post',
        parameters: {
            product_id: productId,
            attribute_name: attributeName,
            attribute_value: attributeValue
        },
        onSuccess: function(response) {
            alert('Attribute updated successfully!');
        },
        onFailure: function() {
            alert('Failed to update attribute.');
        }
    });
}



$$('.edit-button').each(function(button) {
    button.observe('click', function(event) {
        var row = event.findElement('tr');
        var productId = row.down('.product-id').innerText;
        var attributeName = row.down('.attribute-name').innerText;
        var attributeValue = row.down('.attribute-value').innerText;
        
        // Show input fields for editing
        row.down('.attribute-value').update('<input type="text" class="edit-input" value="' + attributeValue + '">');
        
        // Replace edit button with save button
        button.replace('<button class="save-button">Save</button>');
        
        // Save button click event
        row.down('.save-button').observe('click', function() {
            var newValue = row.down('.edit-input').value;
            updateProductCustomAttribute(productId, attributeName, newValue);
        });
    });
});


$('.product-name').click(function() {
    var productId = $(this).data('product-id');
    $.ajax({
        url: '/get_product_details.php',
        type: 'post',
        data: { product_id: productId },
        success: function(response) {
            $('#product-details-modal .modal-body').html(response);
            $('#product-details-modal').modal('show');
        },
        error: function() {
            alert('Failed to load product details.');
        }
    });
});
