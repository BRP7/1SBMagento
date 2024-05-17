<?php

class Practice_Permissionpractice_Adminhtml_PermissionpracticeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function viewAction()
    {
        $this->_title($this->__('Custom Menu Item'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/custom_menu_item');
        $this->_addContent($this->getLayout()->createBlock('core/text', 'custom-menu-item')->setText('<h1>Custom Menu Item Content</h1>'));
        $this->renderLayout();

    }





    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'practice_permissionpractice/permissionpractice/index';
                // $isAllowed = Mage::getSingleton('admin/session')->isAllowed($aclResource);
                // var_dump("Is allowed for $aclResource:", $isAllowed);
                // return $isAllowed;
                break;
            case 'delete':
                $aclResource = 'practice_permissionpractice/permissionpractice/delete';
                break;
            case 'edit':
                $aclResource = 'practice_permissionpractice/permissionpractice/edit';
                break;
            case 'save':
                $aclResource = 'practice_permissionpractice/permissionpractice/edit';
                break;
            case 'new':
                $aclResource = 'practice_permissionpractice/permissionpractice/new';
                break;
            default:
                $aclResource = '';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    // protected function _isAllowed()
    // {
    //     $action = strtolower($this->getRequest()->getActionName());
    //     $allowedActions = array('index', 'delete', 'edit', 'new');
    //     if($action == 'edit'){
    //         $allowedActions[] = 'save';
    //     }

    //     if (in_array($action, $allowedActions) ) {
    //         $aclResource = 'practice_permissionpractice/permissionpractice/'.$action;
    //         return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    //     }

    //     return false;
    // }


    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('practice_permissionpractice')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Customgrid'), Mage::helper('adminhtml')->__('Customgrid'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Customgrid'), Mage::helper('adminhtml')->__('Manage Customgrid'));
        return $this;
    }


    public function newAction()
    {
        $this->_forward('edit');
    }


    public function editAction()
    {
        $this->_title($this->__('CUSTOMGRID'))->_title($this->__('Static Blocks'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('practice_permissionpractice/permissionpractice');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_permissionpractice')->__('This block no longer exists.'));
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
        Mage::register('permissionpractice_data', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('practice_permissionpractice')->__('Edit Block') : Mage::helper('practice_permissionpractice')->__('New Block'), $id ? Mage::helper('practice_permissionpractice')->__('Edit Block') : Mage::helper('practice_permissionpractice')->__('New Block'));

        // echo get_class($this->getLayout()->getBlock('ccc_banner_edit'));
        $obj = $this->getLayout()->getBlock('practice_permissionpractice_edit');
        // echo get_class($obj);
        // var_dump("2334",$obj->getData('action'));

        $obj->setData('action', $this->getUrl('*/*/save'));
        // print_r('$obj->getData('action'));

        $this->renderLayout();

    }





    // {
    //     if ($data = $this->getRequest()->getPost()) {
    //         $data = $this->_filterPostData($data);
    //         // Initialize model and set data
    //         $model = Mage::getModel('practice_permissionpractice/permissionpractice');

    //         if ($id = $this->getRequest()->getParam('permissionpractice_id')) {
    //             $model->load($id);
    //         }

    //         // Validating and saving
    //         try {
    //             // Save the data
    //             $model->setData($data)->save();

    //             // Display success message
    //             Mage::getSingleton('adminhtml/session')->addSuccess(
    //                 Mage::helper('practice_permissionpractice')->__('The item has been saved.')
    //             );

    //             // Clear previously saved data from session
    //             Mage::getSingleton('adminhtml/session')->setFormData(false);

    //             // Check if 'Save and Continue' is clicked
    //             if ($this->getRequest()->getParam('back')) {
    //                 $this->_redirect('*/*/edit', array('permissionpractice_id' => $model->getId(), '_current' => true));
    //                 return;
    //             }

    //             // Go to grid
    //             $this->_redirect('*/*/');
    //             return;

    //         } catch (Mage_Core_Exception $e) {
    //             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    //         } catch (Exception $e) {
    //             Mage::getSingleton('adminhtml/session')->addException(
    //                 $e,
    //                 Mage::helper('practice_permissionpractice')->__('An error occurred while saving the item.')
    //             );
    //         }

    //         $this->_getSession()->setFormData($data);
    //         // If there's an error, redirect back to the edit form
    //         $this->_redirect('*/*/edit', array('permissionpractice_id' => $this->getRequest()->getParam('permissionpractice_id')));
    //         return;
    //     }

    //     // If no data was posted, redirect back to the grid
    //     $this->_redirect('*/*/');
    // }



    // public function saveAction()
    // {
    //     if ($data = $this->getRequest()->getPost()) {
    //         // var_dump($data);
    //         $data = $this->_filterPostData($data);
    //         //init model and set data
    //         $model = Mage::getModel('practice_permissionpractice/permissionpractice');

    //         if ($id = $this->getRequest()->getParam('id')) {
    //             // echo $id;
    //             $model->load($id);
    //         }



    //         $model->setData($data);

    //         Mage::dispatchEvent('permissionpractice_form_prepare_save', array('practice_permissionpractice' => $model, 'request' => $this->getRequest()));

    //         //validating
    //         if (!$this->_validatePostData($data)) {
    //             $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
    //             return;
    //         }

    //         // try to save it
    //         try {
    //             echo 12313;
    //             // save the data
    //             $model->save();

    //             // display success message
    //             Mage::getSingleton('adminhtml/session')->addSuccess(
    //                 Mage::helper('practice_permissionpractice')->__('The page has been saved.')
    //             );
    //             // clear previously saved data from session
    //             Mage::getSingleton('adminhtml/session')->setFormData(false);
    //             // check if 'Save and Continue'
    //             if ($this->getRequest()->getParam('back')) {
    //                 $this->_redirect('*/*/edit', array('permissionpractice_id' => $model->getId(), '_current' => true));
    //                 return;
    //             }
    //             // go to grid
    //             $this->_redirect('*/*/');
    //             return;

    //         } catch (Mage_Core_Exception $e) {
    //             $this->_getSession()->addError($e->getMessage());
    //         } catch (Exception $e) {
    //             $this->_getSession()->addException(
    //                 $e,
    //                 Mage::helper('practice_permissionpractice')->__('An error occurred while saving the page.')
    //             );
    //         }

    //         $this->_getSession()->setFormData($data);
    //         $this->_redirect('*/*/edit', array('permissionpractice_id' => $this->getRequest()->getParam('permissionpractice_id')));
    //         return;
    //     }
    //     $this->_redirect('*/*/');
    // }


    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            Mage::log($data, null, 'permissionpractice_save.log');

            $data = $this->_filterPostData($data);
            $model = Mage::getModel('practice_permissionpractice/permissionpractice');

            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
                Mage::log("Loaded model ID: {$id}", null, 'permissionpractice_save.log');
            }

            $model->addData($data);
            Mage::log("Model data before save:", null, 'permissionpractice_save.log');
            Mage::log($model->getData(), null, 'permissionpractice_save.log');

            Mage::dispatchEvent('permissionpractice_form_prepare_save', array('practice_permissionpractice' => $model, 'request' => $this->getRequest()));

            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                return;
            }

            try {
                $model->save();
                Mage::log("Model data after save:", null, 'permissionpractice_save.log');
                Mage::log($model->getData(), null, 'permissionpractice_save.log');

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_permissionpractice')->__('The page has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('permissionpractice_id' => $model->getId(), '_current' => true));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('practice_permissionpractice')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('permissionpractice_id' => $this->getRequest()->getParam('permissionpractice_id')));
            return;
        }
        $this->_redirect('*/*/');
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



    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }


    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            echo 123;
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('practice_permissionpractice/permissionpractice');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_permissionpractice')->__('The page has been deleted.')
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
                $this->_redirect('*/*/edit', array('permissionpractice_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_permissionpractice')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }


    public function massDeleteAction()
    {
        $permissionpracticeIds = $this->getRequest()->getParam('id');
        if (!is_array($permissionpracticeIds)) {
            $this->_getSession()->addError($this->__('Please select permissionpractice(s).'));
        } else {
            if (!empty($permissionpracticeIds)) {
                try {
                    foreach ($permissionpracticeIds as $permissionpracticeId) {
                        $banner = Mage::getSingleton('practice_permissionpractice/permissionpractice')->load($permissionpracticeId);
                        $banner->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($permissionpracticeIds))
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
        $permissionpracticeIds = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($permissionpracticeIds)) {
            $permissionpracticeIds = array($permissionpracticeIds);
        }

        try {
            foreach ($permissionpracticeIds as $permissionpracticeId) {
                $banner = Mage::getModel('practice_permissionpractice/permissionpractice')->load($permissionpracticeId);
                if ($banner->getStatus() != $status) {
                    $banner->setStatus($status)->save();
                }
            }
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($permissionpracticeIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($permissionpracticeIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }

}
