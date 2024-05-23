<?php

class Practice_Permissionpractice_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('practice_permissionpractice/customer.phtml');
    }

    public function getCustomers()
    {
        // Subquery for total amount per customer
        $transactionCollection = Mage::getModel('sales/order')->getCollection();
        $transactionCollection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('customer_id', 'total_amount' => new Zend_Db_Expr('SUM(base_grand_total)')))
            ->group('customer_id');

        // Subquery for average total amount
        $avgTransactionCollection = Mage::getModel('sales/order')->getCollection();
        $avgTransactionCollection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('average_amount' => new Zend_Db_Expr('AVG(total_amount)')))
            ->from(array('totals' => $transactionCollection->getSelect()));

        // Main customer collection
        $customerCollection = Mage::getModel('customer/customer')->getCollection();
        $customerCollection->addAttributeToSelect('firstname')
                           ->addAttributeToSelect('lastname')
                           ->addAttributeToSelect('email');
        $customerCollection->getSelect()
            ->joinLeft(
                array('t' => new Zend_Db_Expr('(' . $transactionCollection->getSelect()->assemble() . ')')),
                't.customer_id = e.entity_id',
                array('total_amount')
            )
            ->join(
                array('avg' => new Zend_Db_Expr('(' . $avgTransactionCollection->getSelect()->assemble() . ')')),
                '',
                array('average_amount')
            )
            ->where('t.total_amount IS NOT NULL')
            ->having('t.total_amount > avg.average_amount')
            ->group('e.entity_id');

        return $customerCollection;
    }

//     SELECT e.*, t.total_amount, avg.average_amount
//     FROM customer_entity AS e
//     LEFT JOIN (
//     SELECT main_table.customer_id, SUM(base_grand_total) AS total_amount
//     FROM sales_flat_order AS main_table
//     GROUP BY main_table.customer_id
//     ) AS t ON t.customer_id = e.entity_id
//      CROSS JOIN (
//     SELECT AVG(total_amount) AS average_amount
//     FROM (
//         SELECT customer_id, SUM(base_grand_total) AS total_amount
//         FROM sales_flat_order
//         GROUP BY customer_id
//     ) AS totals
// ) AS avg
// WHERE e.entity_type_id = '1'
// GROUP BY e.entity_id
// HAVING SUM(t.total_amount) > avg.average_amount;


// Customer Events
// customer_login
// customer_logout
// customer_save_before
// customer_save_after
// customer_delete_before
// customer_delete_after
// Order Events
// sales_order_place_before
// sales_order_place_after
// sales_order_save_before
// sales_order_save_after
// sales_order_invoice_save_before
// sales_order_invoice_save_after
// sales_order_shipment_save_before
// sales_order_shipment_save_after
// Product Events
// catalog_product_save_before
// catalog_product_save_after
// catalog_product_delete_before
// catalog_product_delete_after
// Category Events
// catalog_category_save_before
// catalog_category_save_after
// catalog_category_delete_before
// catalog_category_delete_after
// Cart Events
// checkout_cart_save_before
// checkout_cart_save_after
// Core Events List
// Global Events:

// controller_action_predispatch
// controller_action_postdispatch
// core_block_abstract_to_html_before
// core_block_abstract_to_html_after
// Adminhtml Events:

// adminhtml_controller_action_predispatch
// adminhtml_controller_action_postdispatch

}
