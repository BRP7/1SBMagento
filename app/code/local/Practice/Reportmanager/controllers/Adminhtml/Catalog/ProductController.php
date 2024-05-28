<?php
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';
class Practice_Reportmanager_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    // public function saveReportAction()
    // {
    //     $user = Mage::getSingleton('admin/session')->getUser();
    //     $filters = $this->getRequest()->getParam('filter'); // Or retrieve filters in the way you use
        
    //     $model = Mage::getModel('company_module/cc_filter_report');
    //     $model->setUserId($user->getId());
    //     $model->setFilters(serialize($filters)); // Or use json_encode
    //     $model->save();
    
    //     Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('Report saved successfully.'));
    //     $this->_redirect('*/*/');
    // }
    

    public function saveReportAction()
{
    $user = Mage::getSingleton('admin/session')->getUser();
    $filters = $this->getRequest()->getParam('filter'); // Retrieve the filters from the request

    if ($filters) {
        try {
            $model = Mage::getModel('company_module/cc_filter_report');
            $model->setUserId($user->getId());
            $model->setReportType('product'); // Set the report type, for example, 'product'
            $model->setFilterData(json_encode($filters)); // Store the filters in JSON format
            $model->setIsActive(1); // Set the report as active
            $model->setCreatedAt(now());
            $model->setUpdatedDate(now());
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('Report saved successfully.'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    } else {
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('catalog')->__('No filters to save.'));
    }

    $this->_redirect('*/*/');
}

    
}
