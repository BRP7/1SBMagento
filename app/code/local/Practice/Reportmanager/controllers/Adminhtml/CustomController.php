<?php

class Practice_Reportmanager_Adminhtml_CustomController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice_reportmanager/report_manager');
        $this->_title($this->__('Report Manager'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function editAction()
    {
        $this->_title($this->__('locationcheck'))->_title($this->__('locationcheck'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('practice_reportmanager/reportmanager');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('locationcheck')->__('This locationcheck no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New locationcheck'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData();
        if (!empty($data)) {

            $model->setData($data);
        }

        Mage::register('reportmanager_data', $model);
        
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'), $id ? Mage::helper('locationcheck')->__('Edit locationcheck') : Mage::helper('locationcheck')->__('New locationcheck'));
        $this->renderLayout();

    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout();
        $this->_setActiveMenu('practice_reportmanager/reportmanager');
        return $this;
    }
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
        $filters = $this->getRequest()->getParams();

        if ($filters) {
            try {
                $model = Mage::getModel('practice_reportmanager/reportmanager');
                $model->setUserId($user->getId());
                $model->setReportType('product');
                $model->setFilterData(json_encode($filters));
                $model->setIsActive(1);
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

    // public function saveCustomerReportAction()
    // {
    //     $user = Mage::getSingleton('admin/session')->getUser();
    //     $filters = $this->getRequest()->getParams(); // Retrieve the filters from the request

    //     if ($filters) {
    //         try {
    //             $model = Mage::getModel('practice_reportmanager/reportmanager');
    //             $model->setUserId($user->getId());
    //             $model->setReportType('customer'); // Set the report type to 'customer'
    //             $model->setFilterData(json_encode($filters)); // Store the filters in JSON format
    //             $model->setIsActive(1); // Set the report as active
    //             $model->setCreatedAt(now());
    //             $model->setUpdatedDate(now());
    //             $model->save();

    //             Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customer')->__('Customer report saved successfully.'));
    //         } catch (Exception $e) {
    //             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    //         }
    //     } else {
    //         Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customer')->__('No filters to save.'));
    //     }

    //     $this->_redirect('*/*/');
    // }
}