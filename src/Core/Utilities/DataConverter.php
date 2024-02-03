<?php
namespace Core\Utilities;

class DataConverter{
    public static function markdownToHtml($markdown){
        $decodedMarkdown = nl2br($markdown);
        $decodedMarkdown = preg_replace('/\*\*\*(.*?)\*\*\*/s', '<u>$1</u>', $decodedMarkdown);
        $decodedMarkdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $decodedMarkdown);
        $decodedMarkdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $decodedMarkdown);
        return $decodedMarkdown;
    }
}