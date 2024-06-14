<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpfile extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'ccc_filetransfer';
        $this->_controller = 'adminhtml_ftpfile';
        $this->_headerText = Mage::helper('ccc_filetransfer')->__('Manage FTP Files');
        parent::__construct();
    }

}
