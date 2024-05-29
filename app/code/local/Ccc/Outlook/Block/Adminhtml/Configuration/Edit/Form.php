<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_form');
        $this->setTitle(Mage::helper('ccc_outlook')->__('Configuration Information'));
        $this->setData('configuration_form', $this->getUrl('*/*/save'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('configuration_data');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');


        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('ccc_outlook')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getId()) {
            $fieldset->addField(
                'configuration_id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }


        $fieldset->addField(
            'username',
            'text',
            array(
                'name' => 'username',
                'label' => Mage::helper('ccc_outlook')->__('User Name'),
                'title' => Mage::helper('ccc_outlook')->__('User Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'email',
            'text',
            array(
                'name' => 'email',
                'label' => Mage::helper('ccc_outlook')->__('Email'),
                'title' => Mage::helper('ccc_outlook')->__('Email'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'api_key',
            'text',
            array(
                'name' => 'api_key',
                'label' => Mage::helper('ccc_outlook')->__('API Key'),
                'title' => Mage::helper('ccc_outlook')->__('API Key'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'token',
            'text',
            array(
                'name' => 'token',
                'label' => Mage::helper('ccc_outlook')->__('Token'),
                'title' => Mage::helper('ccc_outlook')->__('Token'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => Mage::helper('ccc_outlook')->__('configuration Is Active'),
                'title' => Mage::helper('ccc_outlook')->__('configuration Is Active'),
                // Remove 'required' attribute only in edit mode
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('ccc_outlook')->__('Yes'),
                    '0' => Mage::helper('ccc_outlook')->__('No'),
                ),
            )
        );

            if (!($model->getId())) {
                $model->setData('is_active', 'no');
            }
       

      
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
?>