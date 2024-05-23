<?php
class Practice_Rowedit_Block_Adminhtml_Rowedit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_rowedit';
        $this->_blockGroup = 'practice_rowedit';
        $this->_headerText = Mage::helper('practice_rowedit')->__('Rowedit');
        parent::__construct();   
        
        $this->_addButton('custom', array(
            'label'     =>'Custom',
            'class'     => 'cus',
        ));
    }


    // This query retrieves all products with a price greater than the average price of all products.
// $collection = Mage::getModel('catalog/product')->getCollection();

// $subquery = Mage::getModel('catalog/product')->getCollection()
//     ->addAttributeToSelect('price')
//     ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);

// $avgPrice = $subquery->getSelect()->columns(array('average_price' => new Zend_Db_Expr('AVG(price)')));

// $collection->addFieldToFilter('price', array('gt' => $avgPrice));

// // Execute $collection->load() to get the result set




// Scenario 2: Finding Customers with High Transaction Amounts

// Question: In a normal SQL database, you want to find all customers who have made transactions with a total amount greater than the average transaction amount.

// Example Answer (SQL):

// sql
// Copy code
// -- SQL Example
// SELECT customer_id
// FROM transactions
// GROUP BY customer_id
// HAVING SUM(amount) > (
//     SELECT AVG(total_amount)
//     FROM (
//         SELECT SUM(amount) AS total_amount
//         FROM transactions
//         GROUP BY customer_id
//     ) AS subquery
// );
    
}
