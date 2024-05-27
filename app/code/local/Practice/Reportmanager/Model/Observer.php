<?php
class Practice_Reportmanager_Model_Observer {

public function customSalesOrderItemBeforeSave(Varien_Event_Observer $observer) {
    $item = $observer->getEvent()->getItem();
    $oldItem = Mage::getModel('sales/order_item')->load($item->getId());

    if ($oldItem->getId()) {
        $oldQty = $oldItem->getQtyOrdered();
        Mage::getSingleton('core/session')->setData('old_qty_' . $item->getId(), $oldQty);
        Mage::log("Old Qty set in session --> {$oldQty}", null, 'sold_count_out.log');
    }
}

public function customSalesOrderItemAfterSave(Varien_Event_Observer $observer) {
    $item = $observer->getEvent()->getItem();
    $productId = $item->getProductId();
    $newQty = $item->getQtyOrdered();
    $oldQty = Mage::getSingleton('core/session')->getData('old_qty_' . $item->getId());

    if ($oldQty === null) {
        $oldQty = 0;
    }

    $productModel = Mage::getModel('catalog/product')->load($productId);
    $soldQty = $productModel->getData('sold_count') ? $productModel->getData('sold_count') : 0;

    $soldCount = ($soldQty - $oldQty) + $newQty;
    $productModel->setData('sold_count', $soldCount)->save();
    Mage::log("Updated sold_count for product ID {$productId}: {$soldCount}", null, 'sold_count.log');

    // Clear the session variable after use
    Mage::getSingleton('core/session')->unsetData('old_qty_' . $item->getId());
}

public function customSalesOrderBeforeDelete(Varien_Event_Observer $observer) {
    $order = $observer->getEvent()->getOrder();
    foreach ($order->getAllItems() as $item) {
        $productId = $item->getProductId();
        $qty = $item->getQtyOrdered();
        $productModel = Mage::getModel('catalog/product')->load($productId);
        $soldQty = $productModel->getData('sold_count') ? $productModel->getData('sold_count') : 0;

        $soldCount = $soldQty - $qty;
        $productModel->setData('sold_count', $soldCount)->save();
        Mage::log("Decremented sold_count for product ID {$productId}: {$soldCount}", null, 'sold_count.log');
    }
}
}
