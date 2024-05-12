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


    public function newAction()
    {
        $this->_forward('edit');
    }

    // public function editAction()
    // {
    //     // Set the page title
    //     $this->_title($this->__('Manage Customgrid'));

    //     // Get the customgrid ID from the request parameters
    //     $id = $this->getRequest()->getParam('customgrid_id');

    //     // Load the customgrid model based on the ID
    //     $model = Mage::getModel('practice_customgrid/customgrid');

    //     // Initial checking
    //     if ($id) {
    //         $model->load($id);
    //         if (!$model->getId()) {
    //             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This customgrid does not exist.'));
    //             $this->_redirect('*/*/');
    //             return;
    //         }
    //     }

    //     // Set the page title based on whether it's a new customgrid or an edit action
    //     $this->_title($model->getId() ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));

    //     // Set entered data if there was an error during saving
    //     $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    //     Mage::log($data); // Let's log the data to see what's happening
    //     if (!empty($data)) {
    //         Mage::log('Setting form data to model');
    //         $model->setData($data);
    //     }

    //     // Register the customgrid model to use it later in blocks
    //     Mage::register('customgrid_data', $model);

    //     // Initialize the action
    //     $this->_initAction();

    //     // Add breadcrumbs
    //     $this->_addBreadcrumb($id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'), $id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));

    //     // Get the edit form block
    //     $editBlock = $this->getLayout()->createBlock('practice_customgrid/adminhtml_customgrid_edit');

    //     // Pass the model data to the edit form block
    //     $editBlock->setCustomgrid($model);

    //     // Set the form action URL
    //     $editBlock->setData('action', $this->getUrl('*/*/save'));

    //     // Render layout
    //     $this->renderLayout();
    // }


    // public function editAction()
    // {
    //     // Set the page title
    //     $this->_title($this->__('Manage Customgrid'));

    //     // Get the customgrid ID from the request parameters
    //     $id = $this->getRequest()->getParam('customgrid_id');

    //     // Load the customgrid model based on the ID
    //     $model = Mage::getModel('practice_customgrid/customgrid');


    //     $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    //     Mage::log($data); // Let's log the data to see what's happening
    //     if (!empty($data)) {
    //         echo "Setting form data to model";
    //         Mage::log('Setting form data to model');
    //         $model->setData($data);
    //     }
    
    //     // Register the customgrid model to use it later in blocks
    //     Mage::register('customgrid_data', $model);
    //     // Initial checking
    //     if ($id) {
    //         $model->load($id);
    //         if (!$model->getId()) {
    //             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This customgrid does not exist.'));
    //             $this->_redirect('*/*/');
    //             return;
    //         }
    //     }

    //     // Set the page title based on whether it's a new customgrid or an edit action
    //     $this->_title($model->getId() ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));

    //     // Set entered data if there was an error during saving
    //     $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    //     var_dump($data);
    //     Mage::log($data); // Let's log the data to see what's happening
    //     if (!empty($data)) {
    //         echo "Setting form data to model";
    //         Mage::log('Setting form data to model');
    //         $model->setData($data);
    //     }

    //     // Register the customgrid model to use it later in blocks
    //     Mage::register('customgrid_data', $model);

    //     // Initialize the action
    //     $this->_initAction();

    //     // Add breadcrumbs
    //     $this->_addBreadcrumb($id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'), $id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));

    //     // Get the edit form block
    //     $editBlock = $this->getLayout()->createBlock('practice_customgrid/adminhtml_customgrid_edit');

    //     // Pass the model data to the edit form block
    //     $editBlock->setCustomgrid($model);

    //     // Set the form action URL
    //     $editBlock->setData('action', $this->getUrl('*/*/save'));

    //     // Render layout
    //     $this->renderLayout();
    // }

//     public function editAction()
// {
//     $this->_title($this->__('Edit Customgrid'));

//     $id = $this->getRequest()->getParam('id');
//     $model = Mage::getModel('practice_customgrid/customgrid');
//     // $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
//     // Mage::log($data); // Let's log the data to see what's happening
//     // if (!empty($data)) {
//     //     Mage::log('Setting form data to model');
//     //     $model->setData($data);
//     // }


//     if ($id) {
//         $model->load($id);
//         if (!$model->getId()) {
//             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This customgrid does not exist.'));
//             $this->_redirect('*/*/');
//             return;
//         }
//     }

//     Mage::register('customgrid_data', $model);

//     $this->_initAction();

//     $this->_addBreadcrumb($id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'), $id ? $this->__('Edit Customgrid') : $this->__('New Customgrid'));

//     $editBlock = $this->getLayout()->createBlock('practice_customgrid/adminhtml_customgrid_edit');
//     $editBlock->setCustomgrid($model);

//     // $this->getLayout()->getBlock('content')->append($editBlock);

//     $this->renderLayout();
// }

// public function editAction()
//     {
//         // $this->_title($this->__('BANNER'))->_title($this->__('Static Blocks'));

//         // 1. Get ID and create model
//         $id = $this->getRequest()->getParam('id');
//         // var_dump($id);
//         $model = Mage::getModel('practice_customgrid/customgrid');

//         // 2. Initial checking
//         if ($id) {
//             $model->load($id);
//             // var_dump($model->load($id));
//             if (!$model->getId()) {
//                 // echo 123;
//                 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This block no longer exists.'));
//                 $this->_redirect('*/*/');
//                 return;
//             }
//         }

//         $this->_title($model->getId() ? $model->getTitle() : $this->__('New Block'));

//         // 3. Set entered data if was error when we do save
//         $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
//         if (!empty($data)) {  
//             $model->setData($data);
//         } elseif ($id) {
//             // If it's an update (ID provided), load existing data into the form
//             $data = $model->getData();
//             Mage::getSingleton('adminhtml/session')->setFormData($data);
//         }

//         Mage::register('customgrid_data', $model);

//         $this->_initAction()
//             ->_addBreadcrumb($id ? Mage::helper('practice_customgrid')->__('Edit Block') : Mage::helper('practice_customgrid')->__('New Block'), $id ? Mage::helper('practice_customgrid')->__('Edit Block') : Mage::helper('practice_customgrid')->__('New Block'));

       
//         $obj = $this->getLayout()->getBlock('practice_customgrid_edit');
      

//         $obj->setData('action', $this->getUrl('*/*/save'));
      

//         $this->renderLayout();

//     }

public function editAction()
    {
        $this->_title($this->__('CUSTOMGRID'))->_title($this->__('Static Blocks'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('practice_customgrid/customgrid');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('This block no longer exists.'));
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
        Mage::register('customgrid_data', $model);

        //      //     ->setData('aa', $this->getUrl('*/*/save'));
        // 5. Build edit form

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('practice_customgrid')->__('Edit Block') : Mage::helper('practice_customgrid')->__('New Block'), $id ? Mage::helper('practice_customgrid')->__('Edit Block') : Mage::helper('practice_customgrid')->__('New Block'));

        // echo get_class($this->getLayout()->getBlock('ccc_banner_edit'));
        $obj = $this->getLayout()->getBlock('practice_customgrid_edit');
        // echo get_class($obj);
        // var_dump("2334",$obj->getData('action'));

        $obj->setData('action', $this->getUrl('*/*/save'));
        // print_r('$obj->getData('action'));

        $this->renderLayout();

    }




    // public function saveAction()
    // {
    //     if ($data = $this->getRequest()->getPost()) {
    //         $data = $this->_filterPostData($data);
    //         // Initialize model and set data
    //         $model = Mage::getModel('practice_customgrid/customgrid');

    //         if ($id = $this->getRequest()->getParam('customgrid_id')) {
    //             $model->load($id);
    //         }

    //         // Validating and saving
    //         try {
    //             // Save the data
    //             $model->setData($data)->save();

    //             // Display success message
    //             Mage::getSingleton('adminhtml/session')->addSuccess(
    //                 Mage::helper('practice_customgrid')->__('The item has been saved.')
    //             );

    //             // Clear previously saved data from session
    //             Mage::getSingleton('adminhtml/session')->setFormData(false);

    //             // Check if 'Save and Continue' is clicked
    //             if ($this->getRequest()->getParam('back')) {
    //                 $this->_redirect('*/*/edit', array('customgrid_id' => $model->getId(), '_current' => true));
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
    //                 Mage::helper('practice_customgrid')->__('An error occurred while saving the item.')
    //             );
    //         }

    //         $this->_getSession()->setFormData($data);
    //         // If there's an error, redirect back to the edit form
    //         $this->_redirect('*/*/edit', array('customgrid_id' => $this->getRequest()->getParam('customgrid_id')));
    //         return;
    //     }

    //     // If no data was posted, redirect back to the grid
    //     $this->_redirect('*/*/');
    // }



    public function saveAction()
    {
        echo 111111;
        if ($data = $this->getRequest()->getPost()) {
            // var_dump($data);
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('practice_customgrid/customgrid');

            if ($id = $this->getRequest()->getParam('id')) {
                // echo $id;
                $model->load($id);
            }

            // Image upload handling
            // try {
            //     if (!empty($_FILES['banner_image']['name'])) {
            //         $uploader = new Varien_File_Uploader('banner_image');
            //         $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            //         $uploader->setAllowRenameFiles(true);
            //         $uploader->setFilesDispersion(false);
            //         $path = Mage::getBaseDir('media') . DS . 'banner' . DS;
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
            var_dump($data);
            $model->setData($data);

            Mage::dispatchEvent('customgrid_form_prepare_save', array('practice_customgrid' => $model, 'request' => $this->getRequest()));

                // var_dump($this->_validatePostData($data));

            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('customgrid_id' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                echo 12313;
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_customgrid')->__('The page has been saved.')
                );
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('customgrid_id' => $model->getId(), '_current' => true));
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
                    Mage::helper('practice_customgrid')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('customgrid_id' => $this->getRequest()->getParam('customgrid_id')));
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
    {        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));

        // Add any custom filtering or validation here
        // In your case, you may not need to filter any data

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
                $model = Mage::getModel('practice_customgrid/customgrid');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_customgrid')->__('The page has been deleted.')
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
                $this->_redirect('*/*/edit', array('customgrid_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_customgrid')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }


    public function massDeleteAction()
    {
        $customgridIds = $this->getRequest()->getParam('customgrid_id');
        // var_dump($customgridIds);
        // die;
        if (!is_array($customgridIds)) {
            $this->_getSession()->addError($this->__('Please select customgrid(s).'));
        } else {
            if (!empty($customgridIds)) {
                try {
                    foreach ($customgridIds as $customgridId) {
                        $banner = Mage::getSingleton('practice_customgrid/customgrid')->load($customgridId);
                        // Mage::dispatchEvent('banner_controller_banner_delete', array('banner' => $banner));
                        $banner->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($customgridIds))
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
        $customgridIds = $this->getRequest()->getParam('customgrid_id');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($customgridIds)) {
            $customgridIds = array($customgridIds);
        }

        try {
            foreach ($customgridIds as $customgridId) {
                $banner = Mage::getModel('practice_customgrid/customgrid')->load($customgridId);
                // Check if the status is different than the one being set
                if ($banner->getStatus() != $status) {
                    $banner->setStatus($status)->save();
                }
            }
            // Use appropriate success message based on the status changed
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($customgridIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($customgridIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }

}
