<?php
class Practice_Exam_Model_Product 
{
 /**
     * Fetch product attribute data
     *
     * @param int $productId
     * @return array
     */
    public function getProductAttributeData($productId)
    {
        // Load the product by ID
        $product = Mage::getModel('catalog/product')->load($productId);
        
        if (!$product->getId()) {
            Mage::log("Product with ID {$productId} does not exist.");
            return [];
        }

        // Fetch desired attributes
        $data = [
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'custom_attribute' => $product->getCustomAttribute(), // Assuming 'custom_attribute' is your attribute code
        ];

        return $data;
    }

    public function getProductsAttributesData(array $productIds)
    {
        // Load the product collection
        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect(['name', 'price', 'custom_attribute']) // Select attributes
            ->addAttributeToFilter('entity_id', ['in' => $productIds]); // Filter by product IDs

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'custom_attribute' => $product->getCustomAttribute(),
            ];
        }

        return $data;
    }
}

// Usage example
$model = Mage::getModel('practice_exam/product');
$productsData = $model->getProductsAttributesData([1, 2, 3]); // Replace with actual product IDs

echo '<pre>';
print_r($productsData);
echo '</pre>';


// Usage example
$model = Mage::getModel('practice_exam/product');
$productData = $model->getProductAttributeData(1); // Replace 1 with the actual product ID

echo '<pre>';
print_r($productData);
echo '</pre>';




