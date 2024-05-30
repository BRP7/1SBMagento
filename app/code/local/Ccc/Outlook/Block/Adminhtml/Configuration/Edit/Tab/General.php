<?php 
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();  
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $model = Mage::registry('configuration_data');

        $fieldset = $form->addFieldset('general_fieldset', array('legend' => Mage::helper('ccc_outlook')->__('Genneral Information')));
        if ($model->getId()) {
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
                'label' => Mage::helper('ccc_outlook')->__('Email'),
                'title' => Mage::helper('ccc_outlook')->__('Email'),
            )
        );

        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('ccc_outlook')->__('User Name'),
                'title' => Mage::helper('ccc_outlook')->__('User Name'),
            )
        );
        
     
        
        $fieldset->addField(
            'api_key',
            'text',
            array(
                'name' => 'app_key',
                'label' => Mage::helper('ccc_outlook')->__('API Key'),
                'title' => Mage::helper('ccc_outlook')->__('API Key'),
            )
        );
        
        $fieldset->addField(
            'token',
            'text',
            array(
                'name' => 'token',
                'label' => Mage::helper('ccc_outlook')->__('Token'),
                'title' => Mage::helper('ccc_outlook')->__('Token'),
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('ccc_outlook')->__('is_active'),
                'title' => Mage::helper('ccc_outlook')->__('is_active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('ccc_outlook')->__('Yes'),
                    '0' => Mage::helper('ccc_outlook')->__('No'),
                ),
            )
        );
        if (!($model->getId())) {
            $model->setData('is_active', '1');
        }
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return Mage::helper('ccc_outlook')->__('General');
    }
    public function getTabTitle()
    {
        return Mage::helper('ccc_outlook')->__('General');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
