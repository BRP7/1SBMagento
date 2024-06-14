<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpconfiguration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_form');
        $this->setTitle(Mage::helper('ccc_filetransfer')->__('Configuration Information'));
        $this->setData('configuration_form', $this->getUrl('*/*/save'));
    }
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('configuration_model');
        $isEdit = ($model && $model->getId());
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );
        $form->setHtmlIdPrefix('block_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('ccc_filetransfer')->__('General Information'), 'class' => 'fieldset-wide'));
        if ($isEdit && $model->getConfigurationId()) {
            $fieldset->addField(
                'configuration_id',
                'hidden',
                array(
                    'name' => 'configuration_id',
                )
            );
        }
        $fieldset->addField(
            'username',
            'text',
            array(
                'name' => 'username',
                'label' => Mage::helper('ccc_filetransfer')->__('User Name'),
                'title' => Mage::helper('ccc_filetransfer')->__('User Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('ccc_filetransfer')->__('Password'),
                'title' => Mage::helper('ccc_filetransfer')->__('Password'),
             
            )
        );
        $fieldset->addField(
            'host',
            'text',
            array(
                'name' => 'host',
                'label' => Mage::helper('ccc_filetransfer')->__('Host'),
                'title' => Mage::helper('ccc_filetransfer')->__('Host'),
                'required' => true,
            )
        );
       
        $fieldset->addField(
            'port',
            'text',
            array(
                'name' => 'port',
                'label' => Mage::helper('ccc_filetransfer')->__('Port'),
                'title' => Mage::helper('ccc_filetransfer')->__('Port'),
                'required' => true,
            )
        );
       
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('ccc_filetransfer')->__('is Active'),
                'title' => Mage::helper('ccc_filetransfer')->__('is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('ccc_filetransfer')->__('Enabled'),
                    '0' => Mage::helper('ccc_filetransfer')->__('Disabled'),
                ),
            )
        );
        if (!($model->getId())) {
            $model->setData('is_active', '1');
        }
        // print_r($model->getData());
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
?>