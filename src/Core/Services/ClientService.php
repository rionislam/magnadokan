<?php
namespace Core\Services;

use Core\Models\Client;
use Core\Utilities\IpInfo;

class ClientService extends Client{

    

    public static function getIp(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function getOs(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                            '/windows nt 10/i'      =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/system-ui/i'          =>  'system-ui',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile',
                            '/cros/i'  =>  'Chrome OS'
                        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }

    public static function getDeviceType(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",$user_agent)){
            return 'Mobile';
        }else{
            return 'Desktop';
        }
       
    }

    public static function getBrowser(){
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
            $browser        = "Unknown Browser";
        
            $browser_array = array(
                                    '/msie/i'      => 'Internet Explorer',
                                    '/firefox/i'   => 'Firefox',
                                    '/safari/i'    => 'Safari',
                                    '/chrome/i'    => 'Chrome',
                                    '/edge/i'      => 'Edge',
                                    '/opera/i'     => 'Opera',
                                    '/netscape/i'  => 'Netscape',
                                    '/maxthon/i'   => 'Maxthon',
                                    '/konqueror/i' => 'Konqueror',
                                    '/mobile/i'    => 'Handheld Browser'
                             );
        
            foreach ($browser_array as $regex => $value)
                if (preg_match($regex, $user_agent))
                    $browser = $value;
        
            return $browser;
    }

    public static function getCountry(){
        return IpInfo::get(self::getIp(), 'country');
    }

    public static function getTimezone(){
        // Get the user's timezone offset from the browser headers
        $timezoneOffset = isset($_SERVER['HTTP_TIMEZONE_OFFSET']) ? intval($_SERVER['HTTP_TIMEZONE_OFFSET']) : 0;

        // Calculate the timezone offset in hours
        $timezoneOffsetHours = $timezoneOffset / 60;
        // Set the timezone using the offset
        $userTimezone = timezone_name_from_abbr("", $timezoneOffsetHours * 60, false);

        return $userTimezone;

    }

    public function init(){
        if(isset($_COOKIE['CLIENT_ID'])){
            $this->update();
        }else{
            $this->add();
        }
    }


    
}