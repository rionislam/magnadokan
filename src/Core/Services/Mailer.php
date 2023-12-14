<?php
namespace Core\Services;

use Core\Application;

class Mailer{
    private function send(string $to, string $from, string $subject, $template){
        $headers = "From: {$from}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; carset=ISO-8859-1\r\n";
        mail($to, $subject, $template, $headers);
    }
    
    public function sendSignupMail($userEmail, $userName){
        $from = "Magnadokan <no-reply@".$_SERVER['HTTP_HOST'].">";
        $subject = "Welcome to Magnadokan";
        $templateFile = Application::$ROOT_DIR."/templates/email/signup.php";
        $template = file_get_contents($templateFile);
        $template = str_replace('{USER NAME}', $userName, $template);
        $template = str_replace('{HOST}', Application::$HOST, $template);
        $this->send($userEmail, $from, $subject, $template);
    }
}