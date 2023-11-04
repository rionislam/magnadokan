<?php 
namespace App;
new Application;
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
class Drive { 
    protected function authenticate($file = null){
       // Initialize the Google API client
        $client = new Google_Client();
        $client->setAuthConfig(Application::$ROOT_DIR.'/client-credentials.json'); // Path to your JSON credentials file
        $client->addScope(Google_Service_Drive::DRIVE);

        // Set the redirect URI to match the one you configured in the Google Cloud Console
        $client->setRedirectUri(App\Application::$HOST.'/oauth2callback.php');

        // Set the approval prompt to "force" to always prompt the user for consent
        $client->setApprovalPrompt('force');

        // Check if a user is already authenticated
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        } else {
            // User is not authenticated, store the file temporarily
            $file_name = tempnam(Application::$ROOT_DIR.'/uploads/', '');
            unlink($file_name);
            move_uploaded_file($file, $file_name);
            $_SESSION['file_name'] = $file_name;
            // If the user is not authenticated, redirect them to Google's OAuth consent screen
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit;
        }

        // If the access token is expired, use the refresh token to obtain a new one
        if ($client->isAccessTokenExpired()) {
            $refreshToken = $client->getRefreshToken();
            $client->fetchAccessTokenWithRefreshToken($refreshToken);
            $_SESSION['access_token'] = $client->getAccessToken();
            setcookie('access_token', $_SESSION['access_token'], time() + 30 * 24 * 60 * 60, '/', $_SERVER['HTTP_HOST'], true, true);
        }

        return $client;

    }

    public function upload_file($file_name, $file_temp_location){
        $client = $this->authenticate($file_temp_location);
        // Upload Files to Google Drive
        $service = new Google_Service_Drive($client);

         // Specify the ID of the target folder where you want to upload the file
         $targetFolderId = '1eqZ2EXV58E7WCU7GE9VzWocgGsXrNG5F'; // Replace with the actual folder ID

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file_name, // Specify the name you want for the uploaded file
            'parents' => [$targetFolderId],
        ]);

        $content = file_get_contents($file_temp_location); // Replace with the path to the file you want to upload

       

        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'Application/pdf', // Replace with the appropriate MIME type for your file
            'uploadType' => 'multipart',
        ]);

        $permission = new Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        
        $service->permissions->create($file->getId(), $permission);

        return $file->getId();
    }
} 
?>