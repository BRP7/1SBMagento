<?php
class Ccc_Filetransfer_Block_Adminhtml_FtpFile_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $fileName = $row->getFileName();
        $html = '';
        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'xml') {
            $url = $this->getUrl('*/*/downloadCsv', array('id' => $row->getFtpId()));
            $html = '<a href="' . $url . '">Download Csv</a>';
        }
        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'zip') {
            $url = $this->getUrl('*/*/extractZip', array('id' => $row->getFtpId()));
            $html = '<a href="' . $url . '">extractZip</a>';
        }
        return $html;
    }

}
