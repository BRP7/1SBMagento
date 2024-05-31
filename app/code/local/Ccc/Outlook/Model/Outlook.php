<?php
class Ccc_Outlook_Model_Outlook
{
    public $tenantId = 'common';
    public $clientId = '2c5db537-aa16-4c09-838b-e74304d3b862';
    public $clientSecret = 'Ouj8Q~uOOmsP7O3vU7PV~wxCHPi2TpRvyryG7dbZ';
    public $redirectUri = 'http://localhost/1SBMagento/outlook';
    // Update with your actual Magento URL
    private $scope = 'https://graph.microsoft.com/Mail.Read';

    public function getAuthorizationUrl()
{
    $authorizationEndpoint = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/authorize";
    $redirectUriEncoded = urlencode($this->redirectUri);
    $authUrl = "$authorizationEndpoint?client_id={$this->clientId}&response_type=code&redirect_uri={$redirectUriEncoded}&scope={$this->scope}";
    return $authUrl;
}


    public function getAccessToken($authorizationCode)
    {
        $tokenEndpoint = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";

        $data = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $authorizationCode,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
            // 'grant_type' => 'client_credentials',
            'scope' => $this->scope
        ];

        $ch = curl_init($tokenEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error fetching access token: ' . curl_error($ch));
        }
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['error'])) {
            throw new Exception('Error in response: ' . $result['error_description']);
        }
        return $result['access_token'];
    }

    public function getEmails()
    {
        // $authCode = Mage::getStoreConfig('ccc_outlook/general/auth_code');
        $accessToken = $this->readTokenFromFile();
        $url = "https://graph.microsoft.com/v1.0/me/messages/";
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
    public function saveTokenToFile($data)
    {
        $filePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'savedata.txt';
        try {
            $io = new Varien_Io_File();
            $io->setAllowCreateFolders(true);
            $io->open(array('path' => Mage::getBaseDir('var') . DS . 'export'));
            $io->streamOpen($filePath, 'w+');
            $io->streamLock(true);
            $io->streamWrite($data);
            $io->streamUnlock();
            $io->streamClose();
            
            return true;
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }
    }
    public function readTokenFromFile()
    {
        $filePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'savedata.txt';

        try {
            $io = new Varien_Io_File();
            if ($io->fileExists($filePath)) {
                $io->open(array('path' => Mage::getBaseDir('var') . DS . 'export'));
                $data = $io->read($filePath);
                return $data;
            } else {
                return 'File does not exist.';
            }
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }
    }
}



