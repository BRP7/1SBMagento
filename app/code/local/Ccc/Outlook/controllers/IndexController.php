<?php

class Ccc_Outlook_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $id = $this->getRequest()->getParam('id');
        $outlookModel = Mage::getModel('ccc_outlook/outlook');
        $configuration = Mage::getModel('ccc_outlook/configuration')->load($id);
        if ($this->getRequest()->getParam('code')) {
            $authCode = $this->getRequest()->getParam('code');
            $tokens = $outlookModel->getAccessToken($configuration,$authCode);
            $outlookModel->saveTokenToFile($tokens,$configuration);
            // $emails = $outlookModel->getEmails();

            // Display emails
            // foreach ($emails as $email) {
            //     echo $email->getSubject() . '<br>';
            // }
        } else {
            // Redirect to Microsoft login page
            $authorizationUrl = 'https://login.microsoftonline.com/' . $outlookModel->tenantId . '/oauth2/v2.0/authorize?' . http_build_query([
                'client_id' => $outlookModel->clientId,
                'response_type' => 'code',
                'redirect_uri' => $outlookModel->redirectUri,
                'response_mode' => 'query',
                'scope' => 'https://graph.microsoft.com/.default',
                'state' => '12345'
            ]);

            $this->_redirectUrl($authorizationUrl);
        }
    }
}
