<?php
class Ccc_Locationcheck_Block_Adminhtml_Locationcheck_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        // $this->setTemplate('banner/grid.phtml');

    }
    protected function _prepareCollection()
    {
        // Load your collection
        $collection = Mage::getModel('ccc_locationcheck/locationcheck')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    // public function checkColumn($column)
    // {
    //     return Mage::getSingleton('admin/session')->isAllowed('ccc_banner/columns/' . $column);
    // }
    // protected function _prepareColumns()
    // {
    //     $columns = array(
    //         'banner_id' => array(
    //             'header' => Mage::helper('locationcheck')->__('Id'),
    //             'align' => 'right',
    //             'width' => '50px',
    //             'index' => 'banner_id',
    //             // 'is_allowed' => $this->checkColumn('id'), // ACL check
    //         ),
    //         'banner_name' => array(
    //             'header' => Mage::helper('banner')->__('Banner Name'),
    //             'align' => 'left',
    //             'index' => 'banner_name',
    //             // 'is_allowed' => $this->checkColumn('name'), // ACL check
    //         ),
    //         'banner_image' => array(
    //             'header' => Mage::helper('banner')->__('Banner Image'),
    //             'align' => 'center',
    //             'index' => 'banner_image',
    //             'renderer' => 'Ccc_Banner_Block_Adminhtml_Banner_Grid_Renderer_Image', // Use custom renderer for image column
    //             // 'is_allowed' => $this->checkColumn('image'), // ACL check

    //         ),
    //         'status' => array(
    //             'header' => Mage::helper('banner')->__('Status'),
    //             'align' => 'left',
    //             'index' => 'status',
    //             // 'is_allowed' => $this->checkColumn('status'), // ACL check

    //         ),
    //         'show_on' => array(
    //             'header' => Mage::helper('banner')->__('Show On'),
    //             'align' => 'left',
    //             'index' => 'show_on',
    //             // 'is_allowed' => $this->checkColumn('showon'), // ACL check

    //         ),
    //     );
    //     // Loop through each column
    //     foreach ($columns as $columnKey => $columnConfig) {
    //         // Add column
    //         if ($columnConfig['is_allowed'] == true) {
    //             $this->addColumn($columnKey, $columnConfig);
    //         }
    //     }
    //     // Add more columns as needed

    //     return parent::_prepareColumns();
    // }


    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('locationcheck')->__('Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        )
        );

        $this->addColumn('zipcode', array(
            'header' => Mage::helper('locationcheck')->__('Zipcode'),
            'align' => 'left',
            'index' => 'zipcode',
            'type' => 'text',
            'column_css_class' => 'row_name',
        )
        );

        $this->addColumn('is_active', array(
            'header' => Mage::helper('locationcheck')->__('Is Active'),
            'align' => 'left',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                'yes' => Mage::helper('locationcheck')->__('Yes'),
                'no' => Mage::helper('locationcheck')->__('No'),
            ),
            'column_css_class' => 'is_active',
        )
        );
        $this->addColumn('created_at', array(
            'header' => Mage::helper('locationcheck')->__('Created Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'created_at',
            'column_css_class' => 'created_at',
            'renderer' => 'ccc_locationcheck/adminhtml_locationcheck_grid_renderer_datetime',
        ));

        $this->addColumn('updated_at', array(
            'header' => Mage::helper('locationcheck')->__('Updated Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'updated_at',
            'column_css_class' => 'updated_at',
            'renderer' => 'ccc_locationcheck/adminhtml_locationcheck_grid_renderer_datetime',
        ));

        // $this->addColumn('edit', array(
        //     'header' => Mage::helper('practice_rowedit')->__('Action'),
        //     'align' => 'left',
        //     'type' => 'action',
        //     'getter' => 'getId',
        //     'actions' => array(
        //         array(
        //             'caption' => Mage::helper('practice_rowedit')->__('Edit'),
        //             'url' => array('base' => '*/*/edit'),
        //             'field' => 'entity_id',
        //         )
        //     ),
        //     'filter' => false,
        //     'sortable' => false,
        //     'index' => 'edit',
        //     'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_editbutton',
        // )
        // );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id'); // Change to 'banner_id'

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('locationcheck')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('locationcheck')->__('Are you sure you want to delete selected locationcheck?')
            )
        );

        $statuses = Mage::getSingleton('ccc_locationcheck/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'is_active',
            array(
                'label' => Mage::helper('locationcheck')->__('Change Is Active'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('locationcheck')->__('Is Active'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('locationcheck_adminhtml_locationcheck_grid_prepare_massaction', array('block' => $this));
        return $this;
    }



}
