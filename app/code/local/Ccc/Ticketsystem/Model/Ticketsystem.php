<?php
class Ccc_Ticketsystem_Model_Ticketsystem extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ticketsystem/ticketsystem');
    }

    public function getFilteredCollection($label)
    {
        $filterCollection = Mage::getModel('ccc_ticketsystem/filter')
            ->getCollection()
            ->addFieldToFilter('label', $label);
        $ticketCollection = $this->getCollection();
        $filters = [];
        foreach ($filterCollection as $filter) {
            $field = $filter->getField();
            $value = $filter->getValue();
            if (!isset($filters[$field])) {
                $filters[$field] = [];
            }
            $filters[$field][] = $value;
        }
        foreach ($filters as $field => $values) {
            if ($field == 'created_at') {
                $daysBack = (int) $values[0];
                $endDate = date('Y-m-d H:i:s');
                $startDate = date('Y-m-d H:i:s', strtotime("-$daysBack days", strtotime($endDate)));
                $ticketCollection->addFieldToFilter('created_at', ['from' => $startDate, 'to' => $endDate]);
            } else if ($field == 'user_comment') {
                $userId = $values[0];
                $subquery = Mage::getModel('ccc_ticketsystem/comment')->getCollection()
                    ->addFieldToFilter('user_id', $userId)
                    ->setOrder('created_at', 'DESC')
                    ->setPageSize(1)
                    ->setCurPage(1)
                    ->getSelect();
                $ticketCollection->getSelect()
                    ->joinInner(
                        array('latest_comment' => new Zend_Db_Expr("($subquery)")),
                        'main_table.ticket_id = latest_comment.ticket_id',
                        array()
                    );
                $ticketCollection->getSelect()->group('main_table.ticket_id');
            } else if (is_array($value)) {
                $ticketCollection->addFieldToFilter($field, ['in' => $values]);
            }
        }
        print_r($ticketCollection->getSelect()->__toString());
        return $ticketCollection;
    }
}
