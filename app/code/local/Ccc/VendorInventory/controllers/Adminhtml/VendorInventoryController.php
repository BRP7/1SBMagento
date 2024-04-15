<?php
class Ccc_VendorInventory_Adminhtml_VendorInventoryController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        // echo 12;
        // $this->loadLayout();
        $this->_title($this->__("Manage Inventory"));
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }
    // protected function _isAllowed()
    // {
    //     $action = strtolower($this->getRequest()->getActionName());
    //     switch ($action) {
    //         case 'delete':
    //             $aclResource = 'ccc_banner/delete';
    //             break;
    //         case 'edit':
    //             $aclResource = 'ccc_banner/edit'; // Is this intended?
    //             break;
    //         case 'new':
    //             $aclResource = 'ccc_banner/new'; // Is this intended?
    //             break;
    //         case 'index':
    //             $aclResource = 'ccc_banner/index';
    //             break;
    //         default:
    //             $aclResource = ''; // Set default ACL resource
    //             break;
    //     }
    //     return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    // }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout();
        $this->_setActiveMenu('ccc_vendorinventory/vendorinventory')
            // ->_addBreadcrumb(Mage::helper('vendorinventory')->__('BANNER'), Mage::helper('vendorinventory')->__('BANNER'))
            // ->_addBreadcrumb(Mage::helper('vendorinventory')->__('Manage Pages'), Mage::helper('vendorinventory')->__('Manage Pages'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('VENDOR INVENTORY'))->_title($this->__('Static Blocks'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ccc_vendorinventory/vendorinventory');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorinventory')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Block'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('vendorinventory_block', $model);

        //      //     ->setData('aa', $this->getUrl('*/*/save'));
        // 5. Build edit form

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('vendorinventory')->__('Edit Block') : Mage::helper('vendorinventory')->__('New Block'), $id ? Mage::helper('vendorinventory')->__('Edit Block') : Mage::helper('vendorinventory')->__('New Block'));

        // echo get_class($this->getLayout()->getBlock('ccc_banner_edit'));
        $obj = $this->getLayout()->getBlock('ccc_vendorinventory_edit');
        // echo get_class($obj);

        $obj->setData('action', $this->getUrl('*/*/save'));
        // print_r($obj->getData('action'));

        $this->renderLayout();

    }


    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('ccc_vendorinventory/vendorinventory');

            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }

            // Image upload handling
            // try {
            //     if (!empty($_FILES['banner_image']['name'])) {
            //         $uploader = new Varien_File_Uploader('banner_image');
            //         $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            //         $uploader->setAllowRenameFiles(true);
            //         $uploader->setFilesDispersion(false);
            //         $path = Mage::getBaseDir('media') . DS . 'vendorinventory' . DS;
            //         $uploader->save($path, $_FILES['banner_image']['name']);

            //         // Delete old image if exists
            //         $oldImage = $model->getData('banner_image');
            //         if (!empty($oldImage)) {
            //             $oldImagePath = Mage::getBaseDir('media') . DS . $oldImage;
            //             if (file_exists($oldImagePath)) {
            //                 unlink($oldImagePath);
            //             }
            //         }

            //         $data['banner_image'] = $uploader->getUploadedFileName();
            //         echo $oldImage;
            //     } elseif (isset($data['banner_image']['delete']) && $data['banner_image']['delete'] == 1) {
            //         // Delete the old image
            //         $oldImage = $model->getData('banner_image');
            //         if (!empty($oldImage)) {
            //             $oldImagePath = Mage::getBaseDir('media') . DS . $oldImage;
            //             if (file_exists($oldImagePath)) {
            //                 unlink($oldImagePath);
            //             }
            //         }

            //         $data['banner_image'] = ''; // Empty the image field if delete checkbox is checked
            //     } else {
            //         unset($data['banner_image']); // Unset the image data if no new image uploaded and not deleting existing one
            //     }
            // } catch (Exception $e) {
            //     Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            //     $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            //     return;
            // }
            $model->setData($data);

            Mage::dispatchEvent('vendorinventory_form_prepare_save', array('vendorinventory' => $model, 'request' => $this->getRequest()));

            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vendorinventory')->__('The page has been saved.')
                );
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('vendorinventory')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }
    protected function _validatePostData($data)
    {
        $errorNo = true;
        if (!empty($data['layout_update_xml']) || !empty($data['custom_layout_update_xml'])) {
            /* @var $validatorCustomLayout Mage_Adminhtml_Model_LayoutUpdate_Validator */
            $validatorCustomLayout = Mage::getModel('adminhtml/layoutUpdate_validator');
            if (!empty($data['layout_update_xml']) && !$validatorCustomLayout->isValid($data['layout_update_xml'])) {
                $errorNo = false;
            }
            if (
                !empty($data['custom_layout_update_xml'])
                && !$validatorCustomLayout->isValid($data['custom_layout_update_xml'])
            ) {
                $errorNo = false;
            }
            foreach ($validatorCustomLayout->getMessages() as $message) {
                $this->_getSession()->addError($message);
            }
        }
        return $errorNo;
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('ccc_vendorinventory/vendorinventory');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vendorinventory')->__('The page has been deleted.')
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorinventory')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $inventoryIds = $this->getRequest()->getParam('id');
        if (!is_array($inventoryIds)) {
            $this->_getSession()->addError($this->__('Please select vendorinventory(s).'));
        } else {
            if (!empty($inventoryIds)) {
                try {
                    foreach ($inventoryIds as $vendorinventoryId) {
                        $vendorinventory = Mage::getSingleton('ccc_banner/vendorinventory')->load($vendorinventoryId);
                        // Mage::dispatchEvent('banner_controller_banner_delete', array('vendorinventory' => $vendorinventory));
                        $vendorinventory->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($inventoryIds))
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
        $inventoryIds = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($inventoryIds)) {
            $inventoryIds = array($inventoryIds);
        }

        try {
            foreach ($inventoryIds as $vendorinventoryId) {
                $vendorinventory = Mage::getModel('ccc_vendorinventory/vendorinventory')->load($vendorinventoryId);
                // Check if the status is different than the one being set
                if ($vendorinventory->getStatus() != $status) {
                    $vendorinventory->setStatus($status)->save();
                }
            }
            // Use appropriate success message based on the status changed
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($inventoryIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($inventoryIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }

}
