<?php

class Practice_Rowedit_Adminhtml_RoweditController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('practice_rowedit')
            ->_addBreadcrumb(Mage::helper('practice_rowedit')->__('ROWEDIT'), Mage::helper('practice_rowedit')->__('Rowedit'))
            ->_addBreadcrumb(Mage::helper('practice_rowedit')->__('Manage Rowedit'), Mage::helper('practice_rowedit')->__('Manage Rowedit'));
        return $this;
    }
    // protected function _isAllowed()
    // {
    //     $action = strtolower($this->getRequest()->getActionName());
    //     switch ($action) {
    //         case 'new':
    //             $aclResource = 'ccc_jethalal/jalebi/actions/new';
    //             break;
    //         case 'edit':
    //             $aclResource = 'ccc_jethalal/jalebi/actions/edit';
    //             break;
    //         case 'save':
    //             $aclResource = 'ccc_jethalal/jalebi/actions/save';
    //             break;
    //         case 'delete':
    //             $aclResource = 'ccc_jethalal/jalebi/actions/delete';
    //             break;
    //         default:
    //             $aclResource = 'ccc_jethalal/jalebi/actions/index';
    //             break;
    //     }
    //     return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    // }
    public function indexAction()
    {
        $this->_title($this->__("Manage Rowedit"));
        $this->_initAction();
        $this->renderLayout();
        Mage::dispatchEvent('Rowedit_event', ['Rowedit','practice']);
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Manage Rowedit'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('practice_rowedit/rowedit');
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('practice_rowedit')->__('This page no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $this->__('Edit Page') : $this->__('New Page'));
        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('practice_rowedit_data', $model);
        // 5. Build edit form
        $this->_initAction()
            // 4. Register model to use later in blocks
            ->_addBreadcrumb(
                $id ? Mage::helper('practice_rowedit')->__('Edit Page')
                    : Mage::helper('practice_rowedit')->__('New Page'),
                $id ? Mage::helper('practice_rowedit')->__('Edit Page')
                    : Mage::helper('practice_rowedit')->__('New Page')
            );
        $this->renderLayout();
    }
    public function saveAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $id = $this->getRequest()->getPost('id');
            $name = $this->getRequest()->getPost('name');
            $description = $this->getRequest()->getPost('description');
            Mage::log($description,null,"save.log");
            $roweditModel = Mage::getModel('practice_rowedit/rowedit');

            if ($id) {
                $roweditModel->addData(['entity_id' => $id]);
                $roweditModel->addData(['name' => $name]);
                $roweditModel->addData(['description' => $description]);
                $roweditModel->save();
            }
            $response = array(
                'success' => true,
                'message' => 'Data saved successfully'
            );
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($response));
        }
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
            /** @var $validatorCustomLayout Mage_Adminhtml_Model_LayoutUpdate_Validator */
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
                $model = Mage::getModel('practice_rowedit/rowedit');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_rowedit')->__('The page has been deleted.')
                );
                // go to grid
                Mage::dispatchEvent('adminhtml_rowedit_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_rowedit_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_rowedit')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('id');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select row(s).'));
        } else {
            if (!empty($ids)) {
                try {
                    foreach ($ids as $id) {
                        $rowedit = Mage::getSingleton('practice_rowedit/rowedit')->load($id);
                        $rowedit->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($ids))
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
        $ids = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status');
        if (!is_array($ids)) {
            $rowids = array($ids);
        }

        try {
            foreach ($ids as $id) {
                $rowids = Mage::getModel('practice_rowedit/rowedit')->load($id);
                // Check if the status is different than the one being set
                // if ($jalebi->getStatus() != $status) {
                //     $jalebi->setStatus($status)->save();
                // }
            }
            // Use appropriate success message based on the status changed
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($rowids))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($rowids))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
}
