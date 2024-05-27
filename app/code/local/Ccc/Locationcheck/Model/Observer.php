<?php

class Ccc_Locationcheck_Model_Observer
{
    public function customSalesOrderBeforeSave(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $shippingAddress = $order->getShippingAddress();

        if ($shippingAddress && $shippingAddress->getAddressType() == 'shipping') {
            $collection = Mage::getModel('ccc_locationcheck/locationcheck')->getCollection();

            foreach ($collection as $location) {
                if ($location->getZipcode() == $shippingAddress->getPostcode()) {
                    $order->setIsLocationChecked(1);
                    Mage::log('Order location checked: ' . $order->getIsLocationChecked(), null, 'order_placement.log');
                }
            }
        }

        $items = $order->getAllItems();
        foreach ($items as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $isExcludeLocationCheck = $product->getData('is_exclude_location_check');
            Mage::log('Product ID: ' . $item->getProductId(), null, 'order_placement_key_one.log');
            Mage::log('Product excluded location check: ' . $isExcludeLocationCheck, null, 'order_placement_key_one.log');

            if ($isExcludeLocationCheck == 1) {
                $order->setProductExecludedLocationChecked(1);

                Mage::log($order->getProductExecludedLocationChecked(), null, 'getdata.log');
                Mage::log('Product excluded location check set to 1 for item ID: ' . $item->getId(), null, 'order_placement_key.log');
            } else {
                Mage::log('Product excluded location check is not set for item ID: ' . $item->getId(), null, 'order_placement_key.log');
            }
        }

        return $this;
    }
}
