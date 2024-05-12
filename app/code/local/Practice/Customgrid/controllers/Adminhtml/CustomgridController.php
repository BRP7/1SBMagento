<?php

class Practice_Customgrid_Adminhtml_CustomgridController extends Mage_Adminhtml_Controller_Action

{
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function viewAction()
    {
        echo 123;
    }
    protected function _initAction()
{
    // Load layout, set active menu, and breadcrumbs
    $this->loadLayout()
        ->_setActiveMenu('practice_customgrid')
        ->_addBreadcrumb(Mage::helper('adminhtml')->__('Customgrid'), Mage::helper('adminhtml')->__('Customgrid'))
        ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Customgrid'), Mage::helper('adminhtml')->__('Manage Customgrid'));
    return $this;
}


    public function newAction(){
        $this->_forward('edit');
    }

    public function editAction()
    {
        // Set the page title
        $this->_title($this->__('Manage Customgrid'));
    
        // Get the customgrid ID from the request parameters
        $id = $this->getRequest()->getParam('customgrid_id');
    
        // Load the customgrid model based on the ID
        $model = Mage::getModel('practice_customgrid/customgrid');
    
        // Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This customgrid does not exist.'));
                $this->_redirect('*/*/');
                return;
            }
        }
    
        // Set the page title based on whether it's a new customgrid or an edit action
        $this->_title($model->getId() ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));
    
        // Set entered data if there was an error during saving
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
    
        // Register the customgrid model to use it later in blocks
        Mage::register('customgrid_data', $model);
    
        // Initialize the action
        $this->_initAction();
    
        // Add breadcrumbs
        $this->_addBreadcrumb($id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'), $id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));
    
        // Get the edit form block
        $editBlock = $this->getLayout()->createBlock('practice_customgrid/adminhtml_customgrid_edit');
    
        // Set the form action URL
        $editBlock->setData('action', $this->getUrl('*/*/save'));
    
        // Render layout
        $this->renderLayout();
    }
    
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->_filterPostData($data);
            // Initialize model and set data
            $model = Mage::getModel('practice_customgrid/customgrid');
    
            if ($id = $this->getRequest()->getParam('customgrid_id')) {
                $model->load($id);
            }
    
            // Validating and saving
            try {
                // Save the data
                $model->setData($data)->save();
    
                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_customgrid')->__('The item has been saved.')
                );
    
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
    
                // Check if 'Save and Continue' is clicked
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('customgrid_id' => $model->getId(), '_current' => true));
                    return;
                }
    
                // Go to grid
                $this->_redirect('*/*/');
                return;
    
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addException(
                    $e,
                    Mage::helper('practice_customgrid')->__('An error occurred while saving the item.')
                );
            }
    
            // If there's an error, redirect back to the edit form
            $this->_redirect('*/*/edit', array('customgrid_id' => $this->getRequest()->getParam('customgrid_id')));
            return;
        }
    
        // If no data was posted, redirect back to the grid
        $this->_redirect('*/*/');
    }

    protected function _filterPostData($data)
    {
        // Add any custom filtering or validation here
        // In your case, you may not need to filter any data

        return $data;
    }
    
}
