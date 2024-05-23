<?php
class Ccc_Locationcheck_Adminhtml_LocationcheckController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Ccc_Locationcheck_Adminhtml_LocationcheckController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('ccc_locationcheck/locationcheck');
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        // var_dump($this->getLayout());die;
        $this->_title($this->__('Manage_Locationcheck'));
        $this->_initAction();
        $this->renderLayout();

        // $block = $this->getLayout()->createBlock('ccc_banner/banner');
        // echo '<pre>';
    }

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'new':
                $aclResource = 'sales/location';
                break;
            case 'edit':
                $aclResource = 'ccc_locationcheck/edit';
                break;
            case 'delete':
                $aclResource = 'ccc_locationcheck/delete';
                break;
            default:
                $aclResource = 'ccc_locationcheck/index';
                break;

        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    /* Create new CMS page
     */
    public function newAction()
    {
        // the same form is used to create and edit
        // echo 12;
        $this->_forward('edit');
        // $this->loadLayout();
        // $this->_addContent($this->getLayout()->createBlock('ccc_banner/adminhtml_banner_edit'));
        // $this->renderLayout();
    }

    public function editAction()
    {

        $this->_title($this->__('locationcheck'))->_title($this->__('locationcheck'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ccc_locationcheck/locationcheck');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('locationcheck')->__('This locationcheck no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New locationcheck'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {

            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('locationcheck_block', $model);
        // 5. Build edit form

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'), $id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'));
        $this->renderLayout();

        //` $this->getLayout()->createBlock('banner/adminhtml_banner_edit')
        //     ->setData('action', $this->getUrl('*/*/save'));`
        // print_r($this->getLayout()->getData('action'));
    }
    /**
     * Save action
     */

    public function saveAction()
    {
        // Check if data sent
        if ($data = $this->getRequest()->getPost()) {
            // Initialize model and set data
            $model = Mage::getModel('ccc_locationcheck/locationcheck');
            var_dump($model);
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }




            // Set other data
            $model->setData($data);

            try {
                // Save the data
                $model->save();

                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('locationcheck')->__('The locationcheck has been saved.')
                );
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                // Go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('locationcheck')->__('An error occurred while saving the locationcheck.')
                );
            }

            // Set form data
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('ccc_locationcheck/locationcheck');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('locationcheck')->__('The page has been deleted.')
                );
                // go to grid
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('locationcheck')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    public function massDeleteAction()
    {
        $locationcheckIds = $this->getRequest()->getParam('id');
        if (!is_array($locationcheckIds)) {
            $this->_getSession()->addError($this->__('Please select locationcheck(s).'));
        } else {
            if (!empty($locationcheckIds)) {
                try {
                    foreach ($locationcheckIds as $locationcheckId) {
                        $location = Mage::getSingleton('ccc_locationcheck/locationcheck')->load($locationcheckId);
                        // Mage::dispatchEvent('banner_controller_banner_delete', array('banner' => $location));
                        $location->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($locationcheckIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $locationcheckIds = $this->getRequest()->getParam('id');
        $isActive = $this->getRequest()->getParam('is_active');

        if (!is_array($locationcheckIds)) {
            $locationcheckIds = array($locationcheckIds);
        }

        try {
            foreach ($locationcheckIds as $locationcheckId) {
                $Location = Mage::getModel('ccc_locationcheck/locationcheck')->load($locationcheckId);
                // Check if the status is different than the one being set
                if ($Location->getIsActive() != $isActive) {
                    $Location->setIsActive($isActive)->save();
                }
            }
            // Use appropriate success message based on the status changed
            if ($isActive == 'yes') {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been Yes.', count($locationcheckIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been No.', count($locationcheckIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }


    public function reportAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    // public function productDetailAction()
    // {
    //     // Retrieve data sent via POST
    //     $data = $this->getRequest()->getPost();
    //     $order_enable = $data['order_enable'];
    //     if(isset($data['product_enable'])){
    //         $product_enable = $data['product_enable'];
    //         $collection = Mage::getModel('sales/order')->getCollection()
    //             ->addFieldToFilter('is_location_checked', $product_enable)
    //             ->addFieldToFilter('product_execluded_location_checked', $order_enable)
    //             // ->getSelect()
    //             // ->reset(Zend_Db_Select::COLUMNS)
    //             // ->columns(array('entity_id'));
    //         ;
    //     }else{
    //         $collection = Mage::getModel('sales/order')->getCollection()
    //         ->addFieldToFilter('product_execluded_location_checked', $order_enable);
    //     }

    //     $collection = $collection->getData();
    //     $orderInfo = [];
    //     foreach ($collection as  $value) {
    //        $orderInfo[]=$value['entity_id'];
    //        print_r($orderInfo);
    //     }
    //     // else {
    //     //     // If key1 or key2 is missing, return an error response
    //     $this->getResponse()->setBody(json_encode($collection));
    //     // }
    // }

    public function productDetailAction()
{
    $data = $this->getRequest()->getPost();
    $order_enable = $data['order_enable'];

    $collection = Mage::getModel('sales/order')->getCollection()
        ->addFieldToFilter('product_execluded_location_checked', $order_enable);

    if (isset($data['product_enable'])) {
        $product_enable = $data['product_enable'];
        $collection->addFieldToFilter('is_location_checked', $product_enable);
    }

    $orderInfo = [];
    foreach ($collection as $order) {
        $orderInfo[] = [
            'entity_id' => $order->getId(),
            'state' => $order->getState(),
            'status' => $order->getStatus(),
            'shipping_description' => $order->getShippingDescription(),
            'grand_total' => $order->getGrandTotal(),
            // Add more columns as needed
        ];
    }
    print_r($orderInfo);

    $this->getResponse()->setBody(json_encode($orderInfo));
}


}