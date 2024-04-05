<?php
class Ccc_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // echo 12;
        $this->loadLayout();
        $this->_title($this->__("Manage Banners"));
        $this->renderLayout();
    }

    public function newAction(){
        $this->_forward('edit');
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            // ->_setActiveMenu('banner/banner')
            // ->_addBreadcrumb(Mage::helper('banner')->__('BANNER'), Mage::helper('banner')->__('BANNER'))
            // ->_addBreadcrumb(Mage::helper('banner')->__('Manage Pages'), Mage::helper('banner')->__('Manage Pages'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('BANNER'))->_title($this->__('Static Blocks'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('ccc_banner/banner');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Block'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('banner_block', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('banner')->__('Edit Block') : Mage::helper('banner')->__('New Block'), $id ? Mage::helper('banner')->__('Edit Block') : Mage::helper('banner')->__('New Block'))
            ->renderLayout();
    }
}
