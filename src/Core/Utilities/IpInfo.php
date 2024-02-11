<?php
namespace Core\Utilities;

class IpInfo{
    public static function get($ip, $purpose){
            $output = 'Unknown ' . $purpose;
            $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), '', strtolower(trim($purpose)));
            $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
            $continents = array(
                "AF" => "Africa",
                "AN" => "Antarctica",
                "AS" => "Asia",
                "EU" => "Europe",
                "OC" => "Australia (Oceania)",
                "NA" => "North America",
                "SA" => "South America"
            );
            if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
                $ipdat = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
                if($ipdat !== false){
                    $ipdat = @json_decode($ipdat);
                    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                        switch ($purpose) {
                            case "location":
                                $output = array(
                                    "city"           => @$ipdat->geoplugin_city,
                                    "state"          => @$ipdat->geoplugin_regionName,
                                    "country"        => @$ipdat->geoplugin_countryName,
                                    "country_code"   => @$ipdat->geoplugin_countryCode,
                                    "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                                    "continent_code" => @$ipdat->geoplugin_continentCode
                                );
                                break;
                            case "address":
                                $address = array($ipdat->geoplugin_countryName);
                                if (@strlen($ipdat->geoplugin_regionName) >= 1)
                                    $address[] = $ipdat->geoplugin_regionName;
                                if (@strlen($ipdat->geoplugin_city) >= 1)
                                    $address[] = $ipdat->geoplugin_city;
                                $output = implode(", ", array_reverse($address));
                                break;
                            case "city":
                                $output = @$ipdat->geoplugin_city;
                                break;
                            case "state":
                                $output = @$ipdat->geoplugin_regionName;
                                break;
                            case "region":
                                $output = @$ipdat->geoplugin_regionName;
                                break;
                            case "country":
                                $output = @$ipdat->geoplugin_countryName;
                                break;
                            case "countrycode":
                                $output = @$ipdat->geoplugin_countryCode;
                                break;
                        }
                    }
                } 
                }
                
            return $output;
    }
}