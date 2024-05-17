<?php

class Practice_Permissionpractice_Block_Adminhtml_Permissionpractice_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('permissionpractice_data');
        
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post'
        ));

        // $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_permissionpractice')->__('General Information'), 'class' => 'fieldset-wide'));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('practice_permissionpractice')->__('Item Information'),
            'class'  => 'fieldset-wide'
        ));

        if ($isEdit && $model->getPermissionpracticeId()) {
            $fieldset->addField(
                'permissionpractice_id',
                'hidden',
                array(
                    'name' => 'permissionpractice_id',
                )
            );
        }
        
        $fieldset->addField('grid_name', 'text', array(
            'name'     => 'grid_name',
            'label'    => Mage::helper('practice_permissionpractice')->__('Grid Name'),
            'title'    => Mage::helper('practice_permissionpractice')->__('Grid Name'),
            'required' => true,
        ));

        $fieldset->addField('show_on', 'text', array(
            'name'     => 'show_on',
            'label'    => Mage::helper('practice_permissionpractice')->__('Show On'),
            'title'    => Mage::helper('practice_permissionpractice')->__('Show On'),
            'required' => true,
        ));

        $fieldset->addField('status', 'select', array(
            'name'     => 'status',
            'label'    => Mage::helper('practice_permissionpractice')->__('Status'),
            'title'    => Mage::helper('practice_permissionpractice')->__('Status'),
            'values'   => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('practice_permissionpractice')->__('Enabled')
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('practice_permissionpractice')->__('Disabled')
                ),
            ),
            'required' => true,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
