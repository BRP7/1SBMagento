<?php

class Practice_Exam_Model_Observer
{

    protected $num=5;
    public function displayCustomMessage()
    {
        $this->num = $this->num + 1;
        // $message = $this->num;
        Mage::getSingleton('core/session')->addNotice($this->num);
        return $this->num;
        // if (Mage::getStoreConfig('practice_exam_settings/general/enable')) {
        //     // $message = Mage::getStoreConfig('practice_exam_settings/general/practice_exam_message');
        //     $this->num = $this->num + 1;
        //     $message = $this->num;
        //     Mage::getSingleton('core/session')->addNotice($message);
        // }
    }


    // public function sendNotificationEmail(Varien_Event_Observer $observer)
    // {
    //     // Retrieve the newly registered customer object
    //     $customer = $observer->getCustomer();

    //     // Retrieve store administrator email
    //     $adminEmail = Mage::getStoreConfig('trans_email/ident_general/email');

    //     // Compose the email content
    //     $emailContent = "A new customer has registered on your website.\n";
    //     $emailContent .= "Customer Name: janki";
    //     $emailContent .= "Customer Email: hey beatiful ";
    //     // Add more customer details if needed

    //     // Send email notification
    //     $mail = Mage::getModel('core/email');
    //     $mail->setToEmail($adminEmail);
    //     $mail->setBody($emailContent);
    //     $mail->setSubject('New Customer Registration Notification');
    //     $mail->setFromEmail('akoliyajanki0212@gmail.com');
    //     $mail->setFromName('Admin');
    //     $mail->setType('text'); // You can change this to 'html' if needed
    //     $mail->send();
    // }

    public function assignProductsToSpecialOffersCategory()
{
    $category = Mage::getModel('catalog/category')->loadByAttribute('name', 'Special Offers');
    
    if (!$category) {
        Mage::log("Category 'Special Offers' does not exist.");
        return;
    }

    $productIds = [1, 2, 3]; // Replace with your actual product IDs

    try {
        foreach ($productIds as $productId) {
            $product = Mage::getModel('catalog/product')->load($productId);
            $categoryIds = $product->getCategoryIds();
            if (!in_array($category->getId(), $categoryIds)) {
                $categoryIds[] = $category->getId();
                $product->setCategoryIds($categoryIds)->save();
                Mage::log("Product ID {$productId} assigned to 'Special Offers'.");
            }
        }
    } catch (Exception $e) {
        Mage::log("Failed to assign products: " . $e->getMessage());
    }
}

public function customAction($observer)
{
    $product = $observer->getEvent()->getProduct();
    print_r($product);
    // Perform custom action here with $product
}

public function logProductChanges($observer)
{
    $product = $observer->getEvent()->getProduct();
    // Log changes in product data
}
}