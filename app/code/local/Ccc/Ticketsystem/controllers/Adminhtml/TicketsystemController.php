<?php
class Ccc_Ticketsystem_Adminhtml_TicketsystemController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_ticketsystem/ticketsystem');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage Ticket system'));
        $this->_initAction();
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


    public function viewAction()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = Mage::getModel('ccc_ticketsystem/ticketsystem')->load($ticketId);
        Mage::register('ticket_data', $ticket);
        $this->loadLayout();
        $this->renderLayout();
    }


    public function addCommentAction()
    {

        var_dump($this->getRequest()->isPost());
        if ($this->getRequest()->isPost()) {
            $title = $this->getRequest()->getPost('title');
            $description = $this->getRequest()->getPost('description');
            
            try {
                $comment = Mage::getModel('yourmodule/comment');
                $comment->setTitle($title);
                $comment->setDescription($description);
                // $comment->setCreatedAt(Mage::getModel('core/date')->gmtDate());
                $comment->save();

                $result = [
                    'status' => 'success',
                    'comment' => [
                        'title' => $title,
                        'description' => $description,
                        // 'created_at' => Mage::helper('core')->formatDate($comment->getCreatedAt(), 'medium', true)
                    ]
                ];
            } catch (Exception $e) {
                $result = ['status' => 'error', 'message' => $e->getMessage()];
            }

            $this->getResponse()->setHeader('Content-Type', 'application/json');
            $this->getResponse()->setBody(json_encode($result));
        }
    }



}

