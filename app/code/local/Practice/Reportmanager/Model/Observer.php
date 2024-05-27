<?php
class Practice_Reportmanager_Model_Observer
{
    public function updateSoldCountSaveBefore(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product');
            $collection = $product->load($item->getProductId());

            if ($collection->getId()) {
                Mage::log('Product loaded with ID: ' . $collection->getId(), null, 'orderSku.  log');
                $soldCount = (int) $collection->getSoldCount();
                $soldCount += (int) $item->getQtyOrdered();
                $product->setSoldCount($soldCount);
                Mage::log('Product Sku: ' . $product->getSoldCount() . ' - Updated Sold Count: ' . $soldCount, null, 'orderSku.log');
                $product->save();
            } else {
                Mage::log('Failed to load product with ID: ' . $item->getProductId(), null, 'orderSku.log');
            }
        }
    }

    public function updateSoldCountDeleteBefore(Varien_Event_Observer $observer)
    {
        Mage::log('Observer method updateSoldCountDeleteBefore triggered', null, 'orderSku.log');

        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());

            if ($product->getId()) {
                Mage::log('Product loaded with ID: ' . $product->getId(), null, 'orderSku.log');
                $soldCount = (int) $product->getSoldCount();
                $soldCount -= (int) $item->getQtyOrdered();
                $product->setSoldCount($soldCount);
                Mage::log('Product Sku: ' . $product->getSku() . ' - Updated Sold Count: ' . $soldCount, null, 'orderSku.log');
                $product->save();
            } else {
                Mage::log('Failed to load product with ID: ' . $item->getProductId(), null, 'orderSku.log');
            }
        }
    }
}
