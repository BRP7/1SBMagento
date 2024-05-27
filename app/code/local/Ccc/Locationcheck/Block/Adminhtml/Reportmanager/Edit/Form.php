<?php
class Practice_Reportmanager_Block_Adminhtml_Reportmanager_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reportmanager_form');
        $this->setTitle(Mage::helper('practice_reportmanager')->__('reportmanager Information'));
        $this->setData('reportmanager_form', $this->getUrl('*/*/save'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('reportmanager_block');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');


        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_reportmanager')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }


        $fieldset->addField(
            'report_type ',
            'text',
            array(
                'name' => 'report_type',
                'label' => Mage::helper('practice_reportmanager')->__('reportmanager report type '),
                'title' => Mage::helper('practice_reportmanager')->__('reportmanager report type '),
                'required' => true,
            )
        );
        $fieldset->addField(
            'user_id ',
            'text',
            array(
                'name' => 'user_id',
                'label' => Mage::helper('practice_reportmanager')->__('reportmanager user id '),
                'title' => Mage::helper('practice_reportmanager')->__('reportmanager user id '),
                'required' => true,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => Mage::helper('practice_reportmanager')->__('reportmanager Is Active'),
                'title' => Mage::helper('practice_reportmanager')->__('reportmanager Is Active'),
                'required' => true,
                'options' => array(
                    1 => Mage::helper('practice_reportmanager')->__('Yes'),
                    0 => Mage::helper('practice_reportmanager')->__('No'),
                ),
            )
        );

            if (!($model->getId())) {
                $model->setData('is_active', 'no');
            }
            if ($isEdit) {
                $fieldset->addField(
                    'created_at',
                    'hidden',
                    array(
                        'name' => 'created_at',
                        'label' => Mage::helper('practice_reportmanager')->__(' Created Date'),
                        'title' => Mage::helper('practice_reportmanager')->__(' Created Date'),
                    )
                );
            }
            if ($isEdit) {
                $fieldset->addField(
                    'updated_at',
                    'hidden',
                    array(
                        'name' => 'updated_at',
                        'label' => Mage::helper('practice_reportmanager')->__('Updated Date'),
                        'title' => Mage::helper('practice_reportmanager')->__('Updated Date'),
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