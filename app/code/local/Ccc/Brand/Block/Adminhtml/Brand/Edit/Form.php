<?php
class Ccc_Brand_Block_Adminhtml_Brand_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $brand = Mage::registry('current_brand');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('brand')->__('Brand Information')));

        $fieldset->addField('value', 'text', array(
            'name' => 'value',
            'label' => Mage::helper('brand')->__('Brand Name'),
            'title' => Mage::helper('brand')->__('Brand Name'),
            'required' => true,
            'value' => $brand->getValue() ? $brand->getValue() : ''
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
