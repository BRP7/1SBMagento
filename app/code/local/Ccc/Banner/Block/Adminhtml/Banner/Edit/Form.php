<?php
// class Ccc_Banner_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
// {

//     protected function _prepareLayout()
//     {
//         parent::_prepareLayout();

//         // // Create back button block
//         // $backButtonBlock = $this->getLayout()->createBlock('adminhtml/widget_button')
//         //     ->setData(
//         //         array(
//         //             'label' => Mage::helper('adminhtml')->__('Back'),
//         //             'onclick' => "setLocation('" . $this->getUrl('*/*/') . "')",
//         //             'class' => 'back',
//         //         )
//         //     );

//         // // Check if back button block is successfully created
//         // if ($backButtonBlock) {
//         //     $this->setChild('back_button', $backButtonBlock);
//         // } else {
//         //     Mage::log('Failed to create back button block.', null, 'my_log.log');
//         // }

//         // return $this;
//     }
//     protected function _prepareForm()
//     {
//         $form = new Varien_Data_Form(
//             array(
//                 'id' => 'edit_form',
//                 'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('banner_id'))),
//                 'method' => 'post',
//                 'enctype' => 'multipart/form-data'
//             )
//         );

//         $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('banner')->__('Banner Information')));

//         $fieldset->addField('banner_img', 'file', array(
//             'label' => Mage::helper('banner')->__('Banner Image'),
//             'required' => true,
//             'name' => 'banner_img',
//         )
//         );
//         $fieldset->addField('banner_name', 'text', array(
//             'label' => Mage::helper('banner')->__('Banner Name'),
//             'required' => true,
//             'name' => 'banner_name',
//         )
//         );
//         $fieldset->addField('show_on', 'radios', array(
//             'label' => Mage::helper('banner')->__('Show On'),
//             'required' => true,
//             'name' => 'show_on',
//             'values' => array(
//                 array('value' => 0, 'label' => Mage::helper('banner')->__('No')),
//                 array('value' => 1, 'label' => Mage::helper('banner')->__('Yes')),
//             ),
//         )
//         );
//         $fieldset->addField('status', 'radios', array(
//             'label' => Mage::helper('banner')->__('Status'),
//             'required' => true,
//             'name' => 'status',
//             'values' => array(
//                 array('value' => 0, 'label' => Mage::helper('banner')->__('Disable')),
//                 array('value' => 1, 'label' => Mage::helper('banner')->__('Enable')),
//             ),
//         )
//         );

//         // Add more fields as needed

//         $form->setUseContainer(true);
//         $this->setForm($form);

//         // Add buttons
//         $this->_addButtons();

//         return parent::_prepareForm();
//     }

//     protected function _addButtons()
//     {
//         $this->setChild(
//             'back_button',
//             $this->getLayout()->createBlock('adminhtml/widget_button')
//                 ->setData(
//                     array(
//                         'label' => Mage::helper('adminhtml')->__('Back'),
//                         'onclick' => "setLocation('" . $this->getUrl('*/*/') . "')",
//                         'class' => 'back',
//                     )
//                 )
//         );

//         $this->setChild(
//             'reset_button',
//             $this->getLayout()->createBlock('adminhtml/widget_button')
//                 ->setData(
//                     array(
//                         'label' => Mage::helper('adminhtml')->__('Reset'),
//                         'onclick' => "setLocation('" . $this->getUrl('*/*/edit') . "')",
//                         'class' => 'reset',
//                     )
//                 )
//         );

//         $this->setChild(
//             'save_button',
//             $this->getLayout()->createBlock('adminhtml/widget_button')
//                 ->setData(
//                     array(
//                         'label' => Mage::helper('adminhtml')->__('Save'),
//                         'onclick' => 'editForm.submit();',
//                         'class' => 'save',
//                     )
//                 )
//         );

//         $this->setChild(
//             'saveandcontinue_button',
//             $this->getLayout()->createBlock('adminhtml/widget_button')
//                 ->setData(
//                     array(
//                         'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
//                         'onclick' => '(\'' . $this->getUrl('*/*/save', array('_current' => true)) . '\');',
//                         'class' => 'save',
//                     )
//                 )
//         );
//     }


//     public function getBackButtonHtml()
//     {
//         return $this->getChildHtml('back_button');
//     }

//     public function getResetButtonHtml()
//     {
//         return $this->getChildHtml('reset_button');
//     }

//     public function getSaveButtonHtml()
//     {
//         return $this->getChildHtml('save_button');
//     }

//     public function getSaveAndContinueButtonHtml()
//     {
//         return $this->getChildHtml('saveandcontinue_button');
//     }
// }




class Ccc_Banner_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_form');
        $this->setTitle(Mage::helper('banner')->__('Banner Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        // if (Mage::getSingleton('banner/adminhtml_banner_config')->isEnabled()) {
        //     $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        // }
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('banner_block');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('banner')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getBannerId()) {
            $fieldset->addField(
                'banner_id',
                'hidden',
                array(
                    'name' => 'banner_id',
                )
            );
        }
        $fieldset->addField(
            'name',
            'text',
            array(
                'name' => 'banner_name',
                'label' => Mage::helper('banner')->__('Banner Name'),
                'title' => Mage::helper('banner')->__('Banner Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'banner_image',
            'file',
            array(
                'name' => 'banner_image',
                'label' => Mage::helper('banner')->__('Banner image'),
                'title' => Mage::helper('banner')->__('Banner image'),
                // Remove 'required' attribute only in edit mode
                'required' => !$isEdit,
                'class' => 'validate-xml-banner-image',
            )
        );

        // Add current image display if in edit mode
        if ($isEdit) {
            $currentImageUrl = $model->getBannerImage();
            if ($currentImageUrl) {
                $fieldset->addField(
                    'current_image',
                    'note',
                    array(
                        'label' => Mage::helper('banner')->__('Current Image'),
                        'text' => '<img src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'banner/' . $currentImageUrl . '" height="200" />'
                    )
                );
            }
        }

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('banner')->__('Status'),
                'title' => Mage::helper('banner')->__('Status'),
                'name' => 'status',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('banner')->__('Enabled'),
                    '0' => Mage::helper('banner')->__('Disabled'),
                ),
            )
        );
        if (!($model->getId())) {
            $model->setData('status', '1');
        }

        $fieldset->addField(
            'show_on',
            'select',
            array(
                'label' => Mage::helper('banner')->__('Show ON'),
                'title' => Mage::helper('banner')->__('Show ON'),
                'name' => 'show_on',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('banner')->__('1'),
                    '0' => Mage::helper('banner')->__('0'),
                ),
            )
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }


    // protected function _prepareForm()
    // {

    //     // print_r($this->getData('action'));

    //     $model = Mage::registry('banner_block');

    //     $form = new Varien_Data_Form(
    //     array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
    //     );

    //     $form->setHtmlIdPrefix('banner_');

    //     $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('banner')->__('General Information'), 'class' => 'fieldset-wide'));

    //     if ($model->getBannerId()) {
    //         $fieldset->addField(
    //             'banner_id',
    //             'hidden',
    //             array(
    //                 'name' => 'banner_id',
    //             )
    //         );
    //     }

    //     $fieldset->addField(
    //         'name',
    //         'text',
    //         array(
    //             'name' => 'banner_name',
    //             'label' => Mage::helper('banner')->__('Banner Name'),
    //             'title' => Mage::helper('banner')->__('Banner Name'),
    //             'required' => true,
    //         )
    //     );

    //     $fieldset->addField(
    //         'image',
    //         'file',
    //         array(
    //             'name' => 'banner_image',
    //             'label' => Mage::helper('banner')->__('Banner Image'),
    //             'title' => Mage::helper('banner')->__('Banner Image'),
    //             'required' => false,
    //         )
    //     );

    //     $fieldset->addField(
    //         'show_on',
    //         'text',
    //         array(
    //             'name' => 'show_on',
    //             'label' => Mage::helper('banner')->__('Show On'),
    //             'title' => Mage::helper('banner')->__('Show On'),
    //             'required' => true,
    //         )
    //     );

    //     $fieldset->addField(
    //         'status',
    //         'radios',
    //         array(
    //             'label' => Mage::helper('banner')->__('Status'),
    //             'required' => false,
    //             'name' => 'status',
    //             'values' => array(
    //                 array('value' => 0, 'label' => Mage::helper('banner')->__('Disable')),
    //                 array('value' => 1, 'label' => Mage::helper('banner')->__('Enable')),
    //             ),
    //         )
    //     );

    //     /**
    //      * Check is single store mode
    //      */
    //     // if (!Mage::app()->isSingleStoreMode()) {
    //     //     $field =$fieldset->addField('store_id', 'multiselect', array(
    //     //         'name'      => 'stores[]',
    //     //         'label'     => Mage::helper('cms')->__('Store View'),
    //     //         'title'     => Mage::helper('cms')->__('Store View'),
    //     //         'required'  => true,
    //     //         'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
    //     //     ));
    //     //     $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
    //     //     $field->setRenderer($renderer);
    //     // }
    //     // else {
    //     //     $fieldset->addField('store_id', 'hidden', array(
    //     //         'name'      => 'stores[]',
    //     //         'value'     => Mage::app()->getStore(true)->getId()
    //     //     ));
    //     //     $model->setStoreId(Mage::app()->getStore(true)->getId());
    //     // }

    //     // $fieldset->addField('status', 'select', array(
    //     //     'label'     => Mage::helper('banner')->__('Status'),
    //     //     'title'     => Mage::helper('banner')->__('Status'),
    //     //     'name'      => 'status',
    //     //     'required'  => true,
    //     //     'options'   => array(
    //     //         '1' => Mage::helper('banner')->__('Enabled'),
    //     //         '0' => Mage::helper('banner')->__('Disabled'),
    //     //     ),
    //     // ));
    //     // if (!$model->getId()) {
    //     //     $model->setData('status', '0');
    //     // }

    //     // $fieldset->addField('banner_name', 'editor', array(
    //     //     'name'      => 'banner_name',
    //     //     'label'     => Mage::helper('banner')->__('banner_name'),
    //     //     'title'     => Mage::helper('banner')->__('banner_name'),
    //     //     'style'     => 'height:36em',
    //     //     'required'  => true,
    //     //     'config'    => Mage::getSingleton('banner/adminhtml_banner_config')->getConfig()
    //     // ));

    //     $form->setValues($model->getData());
    //     $form->setUseContainer(true);
    //     $this->setForm($form);

    //     return parent::_prepareForm();
    // }



}

