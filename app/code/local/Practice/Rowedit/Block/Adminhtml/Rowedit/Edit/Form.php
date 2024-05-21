<?php

class Practice_Rowedit_Block_Adminhtml_Rowedit_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rowform');
        $this->setTitle(Mage::helper('practice_rowedit')->__('Manage Rowedit'));
        $this->setData("rowedit_save", $this->getUrl('*/*/save'));//key in setdata??
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('practice_rowedit_data');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getData('rowedit_save'), 'method' => 'post')
        );

        // $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_rowedit')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getJalebiId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }
        $fieldset->addField(
            'name',
            'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('practice_rowedit')->__('Row Name'),
                'title' => Mage::helper('practice_rowedit')->__('Row Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'description',
            'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('practice_rowedit')->__('Row Name'),
                'title' => Mage::helper('practice_rowedit')->__('Row Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'status',
            'text',
            array(
                'label' => Mage::helper('practice_rowedit')->__('Description'),
                'title' => Mage::helper('practice_rowedit')->__('Description'),
                'name' => 'description',
                'required' => true,
            )
        );
        // $fieldset->addField(
        //     'status',
        //     'select',
        //     array(
        //         'label' => Mage::helper('practice_rowedit')->__('Description'),
        //         'title' => Mage::helper('practice_rowedit')->__('Description'),
        //         'name' => 'status',
        //         'required' => true,
        //         'options' => array(
        //             "1" => "Enabled",
        //             "2" => "Disabled",
        //         ),
        //     )
        // );

        if ($isEdit) {
            $fieldset->addField(
                'created_date',
                'hidden',
                array(
                    'name' => 'created_date',
                    'label' => Mage::helper('practice_rowedit')->__('Rowedit Created Date'),
                    'title' => Mage::helper('practice_rowedit')->__('Rowedit Created Date'),
                )
            );
        }
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

?>