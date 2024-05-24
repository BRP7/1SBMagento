<?php

class Practice_Reportmanager_Model_Observer
{

    public function customSalesOrderBeforeSave(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item) {
            $productId = $item->getProductId();
            $qty = $item->getQtyOrdered();

            // $productModel = Mage::getModel('catalog/product')->load($productId);
            $productModel = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter("entity_id", $productId);
            $soldQty = $productModel->getData('sold_count') ? $productModel->getData('sold_count') : 0;

            if ($item->getId()) {
                $oldItem = Mage::getModel('sales/order_item')->load($item->getId());
                Mage::log("Old Qty --> {$oldItem->getQtyOrdered()}", null, 'sold_count_out.log');
                $oldQty = $oldItem->getQtyOrdered();
                Mage::log("Old Sold Count {$productModel->getData('sold_count')} : Current Qty -->{$item->getQtyOrdered()} : Old Qty --> {$oldItem->getQtyOrdered()}", null, 'sold_count_out.log');
                $soldCount = ($soldQty - $oldQty) + $qty;
            } else {
                $soldCount = $soldQty + $qty;
            }

            $productModel->setData('sold_count', $soldCount)->save();
            Mage::log("Updated sold_count for product ID {$productId}: {$soldCount}", null, 'sold_count.log');
        }
    }

    public function customSalesOrderBeforeDelete(Varien_Event_Observer $observer)
    {
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
