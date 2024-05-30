<?php
require_once Mage::getBaseDir() . '/vendor/autoload.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class Ccc_Outlook_Model_Outlook
{
    protected $clientId;
    protected $clientSecret;
    protected $tenantId;

    public function __construct()
    {
        $this->clientId = '2c5db537-aa16-4c09-838b-e74304d3b862';
        $this->clientSecret = 'Ouj8Q~uOOmsP7O3vU7PV~wxCHPi2TpRvyryG7dbZ';
        $this->tenantId = 'f8cdef31-a31e-4b4a-93e4-5f571e91255a';
        // $this->clientId = Mage::getStoreConfig('ccc_outlook/general/client_id');
        // $this->clientSecret = Mage::getStoreConfig('ccc_outlook/general/client_secret');
        // $this->tenantId = Mage::getStoreConfig('ccc_outlook/general/tenant_id');
    }

    public function getAccessToken()
    {
        $url = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";
        $postFields = http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => 'https://graph.microsoft.com/.default'
        ]);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $json = json_decode($response, true);
        var_dump($json);
        return $json['access_token'] ?? null;
    }
    

    public function processEmails($accessToken)
    {
        $lastReadEmailId = Mage::getStoreConfig('ccc_outlook/general/last_read_email_id') ?? 0;
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $messages = $graph->createRequest("GET", "/me/messages?\$top=10&\$orderby=receivedDateTime desc&\$filter=id gt '$lastReadEmailId'")
            ->setReturnType(Model\Message::class)
            ->execute();

        $parser = Mage::getModel('ccc_outlook/parser');

        foreach ($messages as $message) {
            $parsedEmail = $parser->parseEmail($message);
            $emailId = $this->saveEmail($parsedEmail);

            if (!empty($message->getAttachments())) {
                $this->saveAttachments($message->getAttachments(), $emailId);
            }

            // Update last read email ID
            Mage::getConfig()->saveConfig('ccc_outlook/general/last_read_email_id', $message->getId());
        }
    }

    protected function saveEmail($emailData)
    {
        $emailModel = Mage::getModel('ccc_outlook/email');
        $emailModel->setData($emailData);
        $emailModel->save();
        return $emailModel->getId();
    }

    protected function saveAttachments($attachments, $emailId)
    {
        foreach ($attachments as $attachment) {
            $attachmentModel = Mage::getModel('ccc_outlook/attachment');
            $attachmentModel->setEmailId($emailId);
            $attachmentModel->setFilename($attachment->getName());
            $attachmentModel->setFileContent(base64_encode($attachment->getContentBytes()));
            $attachmentModel->save();
        }
    }

    public function getMail($token)
    {
        if (!$token) {
            // Handle case where access token is not provided
            // You can log an error or throw an exception
            throw new Exception("No access token provided");
        }
    
        $graph = new Graph();
        $graph->setAccessToken($token);
    
        // Assuming you want to read the 10 most recent emails
        $messages = $graph->createRequest("GET", "/users/me/messages?\$top=10&\$orderby=receivedDateTime desc")
            ->setReturnType(Model\Message::class)
            ->execute();
    
        // Loop through each message and print subject and body
        foreach ($messages as $message) {
            $subject = $message->getSubject();
            $body = $message->getBody()->getContent(); // Assuming HTML content
    
            // Print subject and body
            echo "Subject: $subject" . PHP_EOL;
            echo "Body: $body" . PHP_EOL;
            echo "------------------------------" . PHP_EOL;
        }
    }
    
}
