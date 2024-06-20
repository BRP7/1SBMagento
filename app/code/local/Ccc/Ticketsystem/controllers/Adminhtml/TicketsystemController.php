<?php
class Ccc_Ticketsystem_Adminhtml_TicketsystemController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_ticketsystem/ticketsystem');
        return $this;
    }
    // public function indexAction()
    // {
    //     $this->_title($this->__('Manage Ticket system'));
    //     $this->_initAction();
    //         $page = (int) $this->getRequest()->getParam('page', 1);
    //         $limit = (int) $this->getRequest()->getParam('limit', 1);
    //         $block = $this->getLayout()->createBlock('ccc_ticketsystem/adminhtml_ticketsystem');
    //         $block->setPage($page)->setLimit($limit);
    //         $this->loadLayout();
    //         $this->getLayout()->getBlock('content')->append($block);
    //     $this->renderLayout();
    // }


    public function indexAction()
    {
        $page = (int) $this->getRequest()->getParam('page', 1);
        $limit = (int) $this->getRequest()->getParam('limit', 3);
        $block = $this->getLayout()->createBlock('ccc_ticketsystem/adminhtml_ticketsystem')
            ->setNameInLayout('ticketsystem_edit');
        $block->setPage($page)->setLimit($limit);
        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function saveDataAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            print_r($data['description']);
            try {
                $title = $data['title'];
                if ($data['description']) {
                    $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
                }
                $assignTo = $data['assign_to'];
                $assignBy = $data['assign_by'];
                $status = $data['status'];
                print_r($description);
                $ticket = Mage::getModel('ccc_ticketsystem/ticketsystem');
                $ticket->setTitle($title)
                    ->setDescription($description)
                    ->setAssignTo($assignTo)
                    ->setAssignBy($assignBy)
                    ->setStatus($status);
                // print_r($ticket->getData());
                $ticket->save();
                Mage::getSingleton('core/session')->addSuccess('Ticket created successfully.');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Failed to create ticket: ' . $e->getMessage());
            }
        }

        $this->_redirect('*/*/');
    }


    //    public function saveFilterAction()
// {
//     $data = $this->getRequest()->getPost();

    //     foreach ($data as $key => $value) {
//         // Separate key and value using the '=' delimiter
//         list($fieldName, $fieldValue) = explode('=', $value);

    //         $model = Mage::getModel('ccc_ticketsystem/filter');
//         try {
//             $model->setData([
//                 'label' => $fieldName,
//                 'value' => $fieldValue
//             ])->save();
//         } catch (Exception $e) {
//             Mage::logException($e);
//         }
//     }

    //     $response = [
//         'success' => true
//     ];

    //     $this->getResponse()->setHeader('Content-Type', 'application/json');
//     $this->getResponse()->setBody(json_encode($response));
// }

    public function saveFilterAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('data');
            $paramPairs = explode('&', $data);
            $outputArray = [];
            foreach ($paramPairs as $pair) {
                list($key, $value) = explode('=', $pair);
                if ($key === 'label') {
                    $label['label'] = $value;
                } else {
                    $outputArray[] = [
                        'field' => $key,
                        'value' => $value,
                    ];
                }
            }
            foreach ($outputArray as &$entry) {
                $entry['label'] = $label['label'];
            }

            try {
                $resource = Mage::getSingleton('core/resource');
                $writeConnection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('ccc_ticketsystem/filter');
                $writeConnection->insertMultiple($tableName, $outputArray);
                $this->getResponse()->setBody(json_encode(['success' => true]));
            } catch (Exception $e) {
                $this->getResponse()->setBody(json_encode(['success' => false, 'message' => $e->getMessage()]));
            }
        }
    }




    // public function updateTicketAction()
    // {
    //     if ($this->getRequest()->isPost()) {
    //         $postData = $this->getRequest()->getPost();
    //         $ticketId = $postData['ticket_id'];
    //         $title = $postData['title'];
    //         $description = $postData['description'];
    //         $status = $postData['status'];

    //         if ($ticketId) {
    //             try {
    //                 $ticket = Mage::getModel('ticketsystem/ticket')->load($ticketId);
    //                 $ticket->setTitle($title);
    //                 $ticket->setDescription($description);
    //                 $ticket->setStatus($status);
    //                 $ticket->save();

    //                 $response = ['status' => 'success'];
    //             } catch (Exception $e) {
    //                 $response = ['status' => 'error', 'message' => $e->getMessage()];
    //             }
    //         } else {
    //             $response = ['status' => 'error', 'message' => 'Invalid ticket ID'];
    //         }
    //     } else {
    //         $response = ['status' => 'error', 'message' => 'Invalid request'];
    //     }

    //     $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    // }



    public function editAction()
    {
        $ticketId = $this->getRequest()->getPost('ticket_id');
        $field = $this->getRequest()->getPost('field');
        $value = $this->getRequest()->getPost('value');
        try {
            $ticket = Mage::getModel('ccc_ticketsystem/ticketsystem')->load($ticketId);
            if ($ticket->getId()) {
                $ticket->setData($field, $value);
                $ticket->save();

                $response = [
                    'success' => true,
                    'newValue' => $ticket->getData($field)
                ];
            } else {
                throw new Exception('Invalid Ticket ID');
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }



    public function viewAction()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = Mage::getModel('ccc_ticketsystem/ticketsystem')->load($ticketId);
        Mage::register('ticket_data', $ticket);
        $this->loadLayout();
        $this->renderLayout();
    }


    // public function addCommentAction()
    // {
    //     if ($this->getRequest()->isPost()) {
    //         $title = $this->getRequest()->getPost('title');
    //         $description = $this->getRequest()->getPost('description');
    //         $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    //         $ticketId = $this->getRequest()->getPost('ticketid');
    //         $userId = $this->getRequest()->getPost('userid');

    //         try {
    //             $comment = Mage::getModel('ccc_ticketsystem/comment');
    //             $comment->setTitle($title)
    //                 ->setDescription($description)
    //                 ->setTicketId($ticketId)
    //                 ->setUserId($userId)
    //                 ->save();

    //             $comments = Mage::getModel('ccc_ticketsystem/comment')
    //                 ->getCollection()
    //                 ->addFieldToFilter('ticket_id', $ticketId)
    //                 ->setOrder('created_at', 'DESC')
    //                 ->getData();

    //             $result = [
    //                 'status' => 'success',
    //                 'comments' => $comments
    //             ];
    //         } catch (Exception $e) {
    //             $result = ['status' => 'error', 'message' => $e->getMessage()];
    //         }

    //         $this->getResponse()->setHeader('Content-Type', 'application/json');
    //         $this->getResponse()->setBody(json_encode($result));
    //     }
    // }



    public function addCommentAction()
    {
        if ($this->getRequest()->isPost()) {
            $title = $this->getRequest()->getPost('title');
            $description = htmlspecialchars($this->getRequest()->getPost('description'), ENT_QUOTES, 'UTF-8');
            $ticketId = $this->getRequest()->getPost('ticketid');
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();

            try {
                $comment = Mage::getModel('ccc_ticketsystem/comment');
                $comment->setTitle($title)
                    ->setDescription($description)
                    ->setTicketId($ticketId)
                    ->setUserId($userId)
                    ->save();

                // $comments = Mage::getModel('ccc_ticketsystem/comment')
                //     ->getCollection()
                //     ->addFieldToFilter('ticket_id', $ticketId)
                //     ->setOrder('created_at', 'DESC')
                //     ->toArray();

                $block = $this->getLayout()->createBlock('ccc_filemanager/adminhtml_ticketsystemviewcomment');
                $html = $block->toHtml();
                // $this->getResponse()->setHeader('Content-Type', 'application/json');
                $this->getResponse()->setBody($html);

            } catch (Exception $e) {
                $result = ['status' => 'error', 'message' => $e->getMessage()];
                $this->getResponse()->setBody(json_encode($result));
            }

        }
    }


    public function applyFilterAction()
    {

        $label = $this->getRequest()->getPost('label');
        $data = Mage::getModel('ccc_ticketsystem/filter')->getCollection()->addFieldToFilter('label', $label);
        $field = "";
        $values = [];
        foreach ($data as $row) {
            $collection = Mage::getModel('ccc_ticketsystem/filter')->getCollection();

            if ($row->getField() == $field) {
                array_push($values, $row->getValue());
            } else {
                if (!empty($values)) {
                    $collection .= $collection->addFieldToFilter('field', $row->getField())
                        ->addFieldToFilter('value', array('in' => $values));
                }
                $values = [];
                array_push($values, $row->getValue());
                $field = $row->getField();
            }

            // $collection = $collection->addFieldToFilter('field', array('in' => $values));
            print_r($collection);
            // print_r($row->getValue());
        }
        $select = $collection->getSelect();
        $query = (string) $select;

        // Print or log the query
        Mage::log($query);
        $this->getResponse()->setBody(json_encode(['success' => true]));
    }


    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $comment = Mage::getModel('ccc_ticketsystem/comment');
        if (!empty($data['comment_id'])) {
            $comment->load($data['comment_id']);
        }
        $comment->setDescription($data['comment']);
        $comment->setTicketId($data['ticket_id']);
        $comment->setParentId($data['parent_id']);
        $comment->setUserId(Mage::getSingleton('admin/session')->getUser()->getId());
        try {
           $commentId = $comment->save();
            header('Content-Type: application/json');
            $response = [
                'status' => 'success',
                'comment_id' => $commentId, 
                'message' => 'Comment saved successfully.'
            ];
            echo json_encode($response);
                    } catch (Exception $e) {
            $this->getResponse()->setBody(json_encode(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    public function loadAction()
    {
        $comments = Mage::getModel('ccc_ticketsystem/comment')->getCollection();
        $commentData = [];
        foreach ($comments as $comment) {
            $commentData[] = [
                'comment_id' => $comment->getId(),
                'description' => $comment->getDescription(),
                'parent_id' => $comment->getParentId()
            ];
        }
        $this->getResponse()->setBody(json_encode($commentData));
    }

}

