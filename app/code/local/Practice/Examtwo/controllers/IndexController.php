<?php
class Practice_Examtwo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo 1233;
        // var_dump(Mage::helper('practice_examtwo')->isCustomReportsEnabled());
        if (!Mage::helper('practice_examtwo')->isCustomReportsEnabled()) {
            // echo 999;
            $this->_forward('noRoute');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function sidebarAction()
{
    // Retrieve data sent via POST
    $data = $this->getRequest()->getPost();

    // Check if specific keys exist in the data array
    if (isset($data['key1']) && isset($data['key2'])) {
        // Merge the values of key1 and key2
        $mergedValue = $data['key1'] . ' ' . $data['key2'];
        
        // Perform any other desired operation on the merged value
        
        // Return the merged value as a JSON response
        $this->getResponse()->setBody(json_encode(['merged_value' => $mergedValue]));
    } else {
        // If key1 or key2 is missing, return an error response
        $this->getResponse()->setBody(json_encode(['error' => 'Missing key1 or key2']));
    }
}

}
