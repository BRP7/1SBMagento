<?php
class Ccc_Locationcheck_Adminhtml_LocationcheckController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_locationcheck/locationcheck');
        return $this;
    }


    public function indexAction()
    {
        $this->_title($this->__('Manage_Locationcheck'));
        $this->_initAction();
        $this->renderLayout();

    }

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'new':
                $aclResource = 'sales/ccc_location/new';
                break;
            case 'edit':
                $aclResource = 'sales/ccc_location/edit';
                break;
            case 'delete':
                $aclResource = 'sales/ccc_location/delete';
                break;
            case 'report':
                $aclResource = 'sales/ccc_location_report/report';
                break;
            case 'product':
                $aclResource = 'sales/ccc_location_report/product';
                break;
            default:
                $aclResource = 'sales/ccc_location/index';
                break;

        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {

        $this->_title($this->__('locationcheck'))->_title($this->__('locationcheck'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ccc_locationcheck/locationcheck');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('locationcheck')->__('This locationcheck no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New locationcheck'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {

            $model->setData($data);
        }

        Mage::register('locationcheck_block', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'), $id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'));
        $this->renderLayout();
    }


    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('ccc_locationcheck/locationcheck');
            var_dump($model);
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }
            $model->setData($data);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('locationcheck')->__('The locationcheck has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
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
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $title = "";
            try {
                $model = Mage::getModel('ccc_locationcheck/locationcheck');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('locationcheck')->__('The page has been deleted.')
                );
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'fail'));
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('locationcheck')->__('Unable to find a page to delete.'));
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
                if ($Location->getIsActive() != $isActive) {
                    $Location->setIsActive($isActive)->save();
                }
            }
            if ($isActive == 1) {
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
    //     $data = $this->getRequest()->getPost();
    //     $order_enable = $data['order_enable'];
    //     if (isset($data['product_enable'])) {
    //         $product_enable = $data['product_enable'];
    //         $collection = Mage::getModel('sales/order')->getCollection()
    //             ->addFieldToFilter('is_location_checked', $product_enable)
    //             ->addFieldToFilter('product_execluded_location_checked', $order_enable);
    //     } else {
    //         $collection = Mage::getModel('sales/order')->getCollection()
    //             ->addFieldToFilter('product_execluded_location_checked', $order_enable);
    //     }

    //     $collection = $collection->getData();
    //     // $orderInfo = [];
    //     // foreach ($collection as  $order) {
    //     //    $orderInfo[]=$order['entity_id'];
    //     //    print_r($orderInfo);
    //     // }

    //     $orderInfo = [];
    //     foreach ($collection as $order) {
    //         $orderInfo[] = [
    //             'entity_id' => $order['entity_id'],
    //             'state' => $order['status'],
    //             'grand_total' => $order['grand_total'],
    //             'product_execluded_location_checked' => $order['product_execluded_location_checked'],
    //             'is_location_checked' => $order['is_location_checked'],
    //         ];
    //     }

    //     $this->getResponse()->setBody(json_encode($orderInfo));
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

        //getSelect() - returns a Zend_Db_Select object,which is used to build SQL queries.
        // ->join - method provided by the Zend_Db_Select class, 
        //main_table.customer_id refers to the customer_id column in the primary table (the table represented by the collection)

        $collection->getSelect()
        ->join(
            array('customer' => 'customer_entity'),//key is an alias for the table, and the value is the actual table name.
            'main_table.customer_id = customer.entity_id',//string that defines the condition for the join
            array('customer.email')// an array of columns that you want to retrieve from the joined table. 
        );

        // $select->join(
        //     array('alias' => 'table_name'),
        //     'join_condition',
        //     array('columns_to_select')
        // );

        $orderInfo = [];
        foreach ($collection as $order) {
            $orderInfo[] = [
                'entity_id' => $order->getEntityId(),
                'state' => $order->getStatus(),
                'grand_total' => $order->getGrandTotal(),
                'product_execluded_location_checked' => $order->getProductExecludedLocationChecked(),
                'is_location_checked' => $order->getIsLocationChecked(),
                'customer_email' => $order->getEmail(),
            ];
        }

        $this->getResponse()->setBody(json_encode($orderInfo));
    }

}