<?php
namespace Core\Services;

use Core\Application;

class ErrorHandler {
    public static function handleErrors($errno, $errstr, $errfile, $errline) {
        //TODO - Need to comment this out while debugging
        // // Check if the error is a deprecated warning about passing null to a parameter
        if (self::isDeprecatedNullWarning($errno, $errstr)) {
            // Don't handle the deprecated null warning
            return;
        }

        // Log the error
        error_log("Error: [$errno] $errstr in $errfile on line $errline");

        
        // Display a custom error page
        self::displayErrorPage(500); // Internal Server Error by default
        
    }

    public static function handleExceptions($exception) {
        // Log the exception
        error_log("Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());

        // Display a custom error page
        self::displayErrorPage(500); // Internal Server Error by default
    }

    public static function displayErrorPage($statusCode = 500) {
        // Clean output buffer
        ob_end_clean();

        // Set the appropriate HTTP header
        http_response_code($statusCode);

        // Display the corresponding error page
        switch ($statusCode) {
            case 400:
                include(Application::$ROOT_DIR.'/templates/error/400.php'); // Bad Request
                break;
            case 401:
                include(Application::$ROOT_DIR.'/templates/error/401.php'); // Unauthorized
                break;
            case 403:
                include(Application::$ROOT_DIR.'/templates/error/403.php'); // Not Found
                break;
            case 404:
                include(Application::$ROOT_DIR.'/templates/error/404.php'); // Not Found
                break;
            case 606:
                include(Application::$ROOT_DIR.'/templates/error/606.php'); // Not Found
                break;
            default:
                include(Application::$ROOT_DIR.'/templates/error/500.php'); // General Error
        }

        exit;
    }

    private static function isDeprecatedNullWarning($errno, $errstr) {
        // Check if the error is a deprecated warning about passing null to a parameter
        return $errno === E_DEPRECATED && strpos($errstr, 'Passing null to parameter') !== false;
    }

    public static function handleShutdown() {
        $error = error_get_last();
        if ($error !== null && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            // Log the fatal error
            error_log("Fatal error: [{$error['type']}] {$error['message']} in {$error['file']} on line {$error['line']}");

            // Display a custom error page
            self::displayErrorPage();
        }
    }
}