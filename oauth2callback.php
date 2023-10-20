<?php
require 'vendor/autoload.php';

session_start();
// Initialize the Google API client
$client = new Google_Client();
$client->setAuthConfig('client-credentials.json'); // Path to your JSON credentials file
$client->addScope(Google_Service_Drive::DRIVE);

// Set the redirect URI to match the one you configured in the Google Cloud Console
$client->setRedirectUri('http://localhost/oauth2callback.php');

// If the user has granted permission, handle the authorization code
if (isset($_GET['code'])) {
    $authCode = $_GET['code'];

    // Exchange the authorization code for an access token
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Set the access token in the client
    $client->setAccessToken($accessToken);
    $_SESSION['access_token'] = $accessToken;


    // Save the access token to a secure location (e.g., a database) for future use

    // Redirect to a page where you can interact with Google Drive
    header('Location: http://localhost/controllers/'.$_SESSION['redirection_target'].'.controller.php'); // Replace with the actual page URL
} else {
    // The user denied permission, or the request is invalid
    echo 'Authorization was denied or an error occurred.';
}






