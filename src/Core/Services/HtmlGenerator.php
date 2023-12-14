<?php
namespace Core\Services;

use Core\Application;
new Application;

class HtmlGenerator{
    public static function generateHead($seoTags, $pageName=NULL, $noindex=false){
        $host = Application::$HOST;
        $pageCss = (file_exists(Application::$ROOT_DIR."/css/pages/{$pageName}.css")?"<link rel='stylesheet' href='{$host}/css/pages/{$pageName}.css'>": "");
        $pageJsFunctions = (file_exists(Application::$ROOT_DIR."/js/functions/{$pageName}-functions.js")?"<script type='module' src='{$host}/js/functions/{$pageName}-functions.js'></script>": "");
        $robots = '';
        if($noindex == true){
            $robots = "<meta name='robots' content='noindex'>";
        }
        
        return "<meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name='theme-color' content='var(--accent-1)' />
        {$robots}
        {$seoTags}
        <link rel='apple-touch-icon' sizes='180x180' href='{$host}/apple-touch-icon.png'>
        <link rel='icon' type='image/png' sizes='32x32' href='{$host}/favicon-32x32.png'>
        <link rel='icon' type='image/png' sizes='16x16' href='{$host}/favicon-16x16.png'>
        <link rel='manifest' href='{$host}/menifest.json'>
        <base href='{$host}/'/>
        <link rel='stylesheet' href='{$host}/css/style.css'>
        {$pageCss}
        {$pageJsFunctions}
        <script src='js/functions.js'></script>";
    }

   

    public static function generateSeoTags($title = NULL, $description = NULL){
        if($title == NULL){
            $title = TITLE;
        }else{
            $title = $title." | ".TITLE;
        }
        
        if($description == NULL){
            $description = DESCRIPTION;
        }
        
        return "<title>{$title}</title>
        <meta name='description' content=\"{$description}\">";
    }

    public function generatePagination($contentLimit, $contentCount, $activePage, $link){
        $pages = $contentCount/$contentLimit;
        if($pages > 1){
            $pagination = '';
            for($i = 0; $i<=$pages; $i++){
                $location = $i+1;
                $class = ($location == $activePage) ? 'active':'';
                $actualLink = str_replace('{page}', $location, $link);
                $pagination .= "<a href='{$actualLink}'><div class='pagination {$class}'>
                                    {$location}
                                </div></a>";
            }
            return "<div class='paginations'>
                    {$pagination}
                    </div>";
        }
    }

    public static function generateAdminHead($pageTitle, $pageName){
        $host = Application::$HOST;
        $pageCss = (file_exists(Application::$ROOT_DIR."/css/pages/{$pageName}.css")?"<link rel='stylesheet' href='{$host}/css/pages/{$pageName}.css'>": "");
        $pageJsFunctions = (file_exists(Application::$ROOT_DIR."/js/functions/{$pageName}-functions.js")?"<script type='module' src='{$host}/js/functions/{$pageName}-functions.js'></script>": "");
        return "<meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>{$pageTitle} | Admin</title>
        <meta name='robots' content='noindex'>
        <link rel='manifest' href='{$host}/menifest.json'>
        <base href='{$host}/'/>
        <link rel='stylesheet' href='{$host}/css/style.css'>
        <link rel='stylesheet' href='{$host}/css/admin-style.css'>
        {$pageCss}
        {$pageJsFunctions}
        <script src='js/admin-functions.js'></script>";
    }
}