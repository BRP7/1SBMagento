<?php

class Ccc_Filetransfer_Block_Adminhtml_Ftpfile_Grid_Column_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
        public function render(Varien_Object $row)
        {
            $filePath = $row->getData('file_path');
            $actionsHtml = '';
    
            if (substr($filePath, -4) === '.xml') {
                $filePath = $row->getData('file_path');
                $actionsHtml .= $this->_getXmlButtonHtml($row->getId(), $filePath);
            } else {
                $actionsHtml .= $this->_getDownloadButtonHtml($row->getId(),$filePath);
            }
    
            return $actionsHtml;
        }
    
        protected function _getXmlButtonHtml($rowId, $filePath)
    {
        $url = $this->getUrl('*/*/convertXml', array('id' => $rowId, 'file_path' => base64_encode($filePath)));
        return '<a href="' . $url . '">' . Mage::helper('ccc_filetransfer')->__('Convert XML') . '</a>';
    }

    protected function _getDownloadButtonHtml($rowId, $filePath)
    {
        $url = $this->getUrl('*/*/download', array('id' => $rowId, 'file_path' => base64_encode($filePath)));
        return '<a href="' . $url . '">' . Mage::helper('ccc_filetransfer')->__('Download CSV') . '</a>';
    }
    
}
