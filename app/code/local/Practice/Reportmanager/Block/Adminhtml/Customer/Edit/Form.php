<?php

class Practice_Reportmanager_Block_Adminhtml_Customer_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('report_form');
        $this->setTitle(Mage::helper('practice_reportmanager')->__('Banner Information'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('reportmanager_data');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post'
            )
        );

        // $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_reportmanager')->__('General Information'), 'class' => 'fieldset-wide'));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('practice_reportmanager')->__('Item Information'),
            'class' => 'fieldset-wide'
        )
        );

        if ($isEdit && $model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }

        $fieldset->addField('user_id','text', array(
            'name'     => 'user_id',
            'label'    => Mage::helper('practice_reportmanager')->__('User Id'),
            'title'    => Mage::helper('practice_reportmanager')->__('User Id'),
            'value'    => '1',
        ));


        $fieldset->addField('report_type', 'select', array(
            'name' => 'report_type',
            'label' => Mage::helper('practice_reportmanager')->__('Report Type'),
            'title' => Mage::helper('practice_reportmanager')->__('Report Type'),
            'values' => array(
                array(
                    'value' => 'Product',
                    'label' => Mage::helper('practice_reportmanager')->__('Product')
                ),
                array(
                    'value' => 'Customer',
                    'label' => Mage::helper('practice_reportmanager')->__('Customer')
                ),
            ),
            'required' => true,
        )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => Mage::helper('locationcheck')->__('locationcheck Is Active'),
                'title' => Mage::helper('locationcheck')->__('locationcheck Is Active'),
                // Remove 'required' attribute only in edit mode
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('locationcheck')->__('Yes'),
                    '0' => Mage::helper('locationcheck')->__('No'),
                ),
            )
        );

        if ($isEdit) {
            $fieldset->addField(
                'created_at',
                'hidden',
                array(
                    'name' => 'created_at',
                    'label' => Mage::helper('locationcheck')->__(' Created Date'),
                    'title' => Mage::helper('locationcheck')->__(' Created Date'),
                )
            );
        }
        if ($isEdit) {
            $fieldset->addField(
                'updated_at',
                'hidden',
                array(
                    'name' => 'updated_at',
                    'label' => Mage::helper('locationcheck')->__('Updated Date'),
                    'title' => Mage::helper('locationcheck')->__('Updated Date'),
                )
            );
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
