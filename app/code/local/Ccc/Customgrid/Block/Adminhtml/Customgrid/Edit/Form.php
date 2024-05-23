<?php

class Practice_Customgrid_Block_Adminhtml_Customgrid_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('customgrid_data');
        
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post'
        ));

        // $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_customgrid')->__('General Information'), 'class' => 'fieldset-wide'));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('practice_customgrid')->__('Item Information'),
            'class'  => 'fieldset-wide'
        ));

        if ($isEdit && $model->getCustomgridId()) {
            $fieldset->addField(
                'customgrid_id',
                'hidden',
                array(
                    'name' => 'customgrid_id',
                )
            );
        }
        
        $fieldset->addField('grid_name', 'text', array(
            'name'     => 'grid_name',
            'label'    => Mage::helper('practice_customgrid')->__('Grid Name'),
            'title'    => Mage::helper('practice_customgrid')->__('Grid Name'),
            'required' => true,
        ));

        $fieldset->addField('show_on', 'text', array(
            'name'     => 'show_on',
            'label'    => Mage::helper('practice_customgrid')->__('Show On'),
            'title'    => Mage::helper('practice_customgrid')->__('Show On'),
            'required' => true,
        ));

        $fieldset->addField('status', 'select', array(
            'name'     => 'status',
            'label'    => Mage::helper('practice_customgrid')->__('Status'),
            'title'    => Mage::helper('practice_customgrid')->__('Status'),
            'values'   => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('practice_customgrid')->__('Enabled')
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('practice_customgrid')->__('Disabled')
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
