<?php

class Practice_Rowedit_Block_Adminhtml_Rowedit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('roweditGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice_rowedit/rowedit')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('practice_rowedit')->__('Entity Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('practice_rowedit')->__('Row Name'),
            'align' => 'left',
            'index' => 'name',
            'type' => 'text',
            'column_css_class' => 'row_name',
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('practice_rowedit')->__('Row Description'),
            'align' => 'left',
            'index' => 'description',
            'type' => 'text',
            'column_css_class' => 'description',
        ));

        $this->addColumn('created_date', array(
            'header' => Mage::helper('practice_rowedit')->__('Row Created Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'created_date',
            'column_css_class' => 'created_date',
            'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_datetime',
        ));

        $this->addColumn('updated_date', array(
            'header' => Mage::helper('practice_rowedit')->__('Row Updated Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'updated_date',
            'column_css_class' => 'updated_date',
            'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_datetime',
        ));

        $this->addColumn('edit', array(
            'header' => Mage::helper('practice_rowedit')->__('Action'),
            'align' => 'left',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('practice_rowedit')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'entity_id',
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'edit',
            'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_editbutton',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('practice_rowedit')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('practice_rowedit')->__('Are you sure you want to delete selected Row?')
        ));

        Mage::dispatchEvent('practice_rowedit_adminhtml_rowedit_grid_prepare_massaction', array('block' => $this));
        return $this;
    }

    public function getRowClass(Varien_Object $row)
    {
        $primaryKey = $row->getId();
        return 'editable-' . $primaryKey;
    }
}

// class Practice_Rowedit_Block_Adminhtml_Rowedit_Grid extends Mage_Adminhtml_Block_Widget_Grid// {
//     public function __construct()
//     {
//         parent::__construct();
//         //    echo "<h1>Jalebi khao Maja karo</h1>";      
//     }
//     protected function _prepareCollection()
//     {
//         $collection = Mage::getModel('practice_rowedit/rowedit')->getCollection();
//         $this->setCollection($collection);
//         return parent::_prepareCollection();
//     }
//     protected function _prepareColumns()
//     {
//         // Add columns for the grid
//         $collumn = array(
//             'entity_id' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Entity Id'),
//                 'align' => 'right',
//                 'width' => '50px',
//                 'index' => 'entity_id',
//             ),

//             'name' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Row Name'),
//                 'align' => 'left',
//                 'index' => 'name',
//                 'type' => 'text',
//                 'column_css_class' => 'row_name',
//             ),
            
//             'description' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Row Description'),
//                 'align' => 'left',
//                 'index' => 'description',
//                 'type' => 'text',
//                 'column_css_class' => 'description',
//             ),
            

//             // 'status' =>
//             // array(
//             //     'header' => Mage::helper('jethalal')->__('Jalebi Status'),
//             //     'align' => 'left',
//             //     'width' => '50px',
//             //     'index' => 'status',
//             //     'type' => 'options',
//             //     'options' => array(
//             //         "1" => "Enabled",
//             //         "2" => "Disabled",
//             //     ),
//             //     'column_css_class' => 'status',
//             // ),

//             'created_date' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Row Created Date'),
//                 'align' => 'left',
//                 'width' => '200px',
//                 'type' => 'datetime',
//                 'index' => 'created_date',
//                 'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_datetime',

//             ),
//             'updated_date' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Row Updated Date'),
//                 'align' => 'left',
//                 'width' => '200px',
//                 'type' => 'datetime',
//                 'index' => 'updated_date',
//                 'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_datetime',
//             ),
//             'edit' =>
//             array(
//                 'header' => Mage::helper('practice_rowedit')->__('Action'),
//                 'align' => 'left',
//                 'type' => 'action',
//                 'getter' => 'getId',
//                 'actions' => array(
//                     array(
//                         'caption' => Mage::helper('practice_rowedit')->__('Edit'),
//                         'url' => array(
//                             'base' => '*/*/edit',
//                         ),
//                         'field' => 'entity_id',
//                     )
//                 ),
//                 'filter' => false,
//                 'sortable' => false,
//                 'index' => 'edit',
//                 'renderer' => 'practice_rowedit/adminhtml_rowedit_grid_renderer_editbutton',
//             )
//         );
//         foreach ($collumn as $collumnName => $collumnKey) {
//             $this->addColumn($collumnName, $collumnKey);
//         }

//         return parent::_prepareColumns();
//     }

    
    
//     protected function _prepareMassaction()
//     {
//         $this->setMassactionIdField('entity_id');
//         $this->getMassactionBlock()->setFormFieldName('entity_id');

//         $this->getMassactionBlock()->addItem(
//             'delete',
//             array(
//                 'label' => Mage::helper('practice_rowedit')->__('Delete'),
//                 'url' => $this->getUrl('*/*/massDelete'),
//                 'confirm' => Mage::helper('practice_rowedit')->__('Are you sure you want to delete selected Row?')
//             )
//         );

//         // $statuses = array(
//         //     "1" => "Enabled",
//         //     "2" => "Disabled",
//         // );

//         // array_unshift($statuses, array('label' => '', 'value' => ''));
//         // $this->getMassactionBlock()->addItem(
//         //     'status',
//         //     array(
//         //         'label' => Mage::helper('jethalal')->__('Change status'),
//         //         'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
//         //         'additional' => array(
//         //             'visibility' => array(
//         //                 'name' => 'status',
//         //                 'type' => 'select',
//         //                 'class' => 'required-entry',
//         //                 'label' => Mage::helper('jethalal')->__('Status'),
//         //                 'values' => $statuses
//         //             )
//         //         )
//         //     )
//         // );

//         Mage::dispatchEvent('practice_rowedit_adminhtml_rowedit_grid_prepare_massaction', array('block' => $this));
//         return $this;
//     }
//     public function getRowClass(Varien_Object $row)
//     {
//         $primaryKey = $row->getId(); 
//         var_dump($primaryKey);
//         return 'editable-' . $primaryKey;
//     }

//     // public function getRowClass(Varien_Object $row)
//     // {
//     //     return 'product-name';
//     // }
//     // public function getRowId(Varien_Object $row)
//     // {
//     //     return $row->getId();
//     // }

   
//     // public function getRowAttributes($row)
//     // {
//     //     return 'data-row-id="' . $row->getId() . '" data-update-url="' . $this->getUpdateUrl() . '" data-form-key="' . $this->getFormKey() . '"';
//     // }

//     // public function getUpdateUrl(){
//     //     return Mage::getUrl('*/*/edit');
//     // }
// }