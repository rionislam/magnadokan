<?php
namespace Core\Utilities;

class IpInfo{
    private static $ipdatArray = array();

    public static function get($ip, $purpose){
        $output = NULL;
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), '', strtolower(trim($purpose)));
        $support = array("city", "country", "continent", "timeZone");
        
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            if (self::$ipdatArray == NULL) {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 5,
                    ],
                ]);
                $ipdat = @file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip, false, $context);
                
                if ($ipdat !== false) {
                    $ipdat = @json_decode($ipdat);
                    
                    if ($ipdat->geoplugin_status == 200) {
                        self::$ipdatArray = array(
                            'city' => $ipdat->geoplugin_city,
                            'country' => $ipdat->geoplugin_countryName,
                            'continent' => $ipdat->geoplugin_continentName,
                            'timeZone' => $ipdat->geoplugin_timezone
                        );
                    } else {
                        self::$ipdatArray = array(
                            'city' => 'Unknown City',
                            'country' => 'Unknown County',
                            'continent' => 'Unknown Continent',
                            'timeZone' => 'Unknown TimeZone'
                        );
                    }
                } else {
                    // Handle API request failure
                    self::$ipdatArray = array(
                        'city' => 'Unknown City',
                        'country' => 'Unknown County',
                        'continent' => 'Unknown Continent',
                        'timeZone' => 'Unknown TimeZone'
                    );
                }
            }
            
            $output = self::$ipdatArray[$purpose];
        }
        
        return $output;
    }
}
