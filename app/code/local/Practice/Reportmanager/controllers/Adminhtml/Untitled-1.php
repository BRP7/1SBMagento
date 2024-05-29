<?php
class abc{
public function loadReportAction()
    {
        $reportType = $this->getRequest()->getParam('reportType');
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        try {
            $report = Mage::getModel('practice_reportmanager/reportmanager')->getCollection()
                ->addFieldToFilter('user_id', $userId)
                ->addFieldToFilter('report_type', $reportType)
                ->getFirstItem();
    
            if ($report && $report->getIsActive() == 1) {
                $filterData = json_decode($report->getFilterData(), true);
                $response = array(
                    'success' => true,
                    'message' => 'filters loaded',
                    'filters' => $filterData
                );
            } else {
                $response = array('success' => false, 'message' => 'No active report found.');
            }
    
            Mage::log('Response: ' . json_encode($response), null, 'report_debug.log');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => false, 'message' => $e->getMessage())));
        }
    }
}