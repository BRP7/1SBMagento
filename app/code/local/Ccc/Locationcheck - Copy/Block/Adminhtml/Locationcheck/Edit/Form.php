<?php
class Ccc_Locationcheck_Block_Adminhtml_Locationcheck_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('locationcheck_form');
        $this->setTitle(Mage::helper('locationcheck')->__('locationcheck Information'));
        $this->setData('locationcheck_form', $this->getUrl('*/*/save'));
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
        $model = Mage::registry('locationcheck_block');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');


        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('locationcheck')->__('General Information'), 'class' => 'fieldset-wide'));

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
            'zipcode',
            'text',
            array(
                'name' => 'zipcode',
                'label' => Mage::helper('locationcheck')->__('locationcheck zipcode'),
                'title' => Mage::helper('locationcheck')->__('locationcheck zipcode'),
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
                    'yes' => Mage::helper('locationcheck')->__('Yes'),
                    'no' => Mage::helper('locationcheck')->__('No'),
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
?>