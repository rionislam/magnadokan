<?php
namespace Core\Utilities;

class DataConverter{
    public static function markdownToHtml($markdown){

        // Emphasis
        $decodedMarkdown = preg_replace('/\*\*\*(.*?)\*\*\*/s', '<u>$1</u>', $markdown);
        $decodedMarkdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $decodedMarkdown);
        $decodedMarkdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $decodedMarkdown);
    
        // Links
        $decodedMarkdown = preg_replace('/\[(.*?)\]\((.*?)\)/s', '<a href="$2">$1</a>', $decodedMarkdown);
    
        // Lists
        $decodedMarkdown = preg_replace('/\n\s*(?:[*-]|\d+\.)\s*(.*?)(?=\n\s*(?:[*-]|\d+\.)|\z)/s', "\n<li>$1</li>", $decodedMarkdown);
    
        // Convert line breaks to <br>
        $decodedMarkdown = nl2br($decodedMarkdown);
    
        return $decodedMarkdown;
    }

    public static function markdownToText($markdown){
        $html = Self::markdownToHtml($markdown);
        $text = strip_tags($html);
        return $text;
    }
}