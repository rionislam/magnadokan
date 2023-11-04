<?php
namespace App;
use Phpfastcache\Config\ConfigurationOption;
use Phpfastcache\CacheManager;
class Cache{
    public function config()
    {
        $cacheConfig = new ConfigurationOption([
            'path' => $_SERVER['DOCUMENT_ROOT'].'/cache',
            'preventCacheSlams' => true,
            'cacheSlamsTimeout' =>20
        ]);
        
        CacheManager::setDefaultConfig($cacheConfig);
        $cache = CacheManager::getInstance('files');
        return $cache;
    }
}