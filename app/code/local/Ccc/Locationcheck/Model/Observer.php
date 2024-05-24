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
                    Mage::log('Order location checkid: ' . $order->getIsLocationChecked(), null, 'order_placement.log');
                }
            }
        }

        $items = $order->getAllItems();
        foreach ($items as $item) {
            if ($item->getProduct()->getData('is_exclude_location_check')) {
                $item->setProductExcludedLocationCheck(1);
                Mage::log('Product excluded location id: ' . $order->getProductExcludedLocationCheck(), null, 'order_placement_key.log');
            }
        }

        return $this;
    }

}