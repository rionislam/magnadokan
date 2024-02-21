<?php

namespace Core\Utilities;

class Timer{
    public static function timeLeftForNextDay(){
        // Get the current date
        $currentDate = date("Y-m-d");

        // Set the target date to the next day
        $nextDate = date("Y-m-d", strtotime($currentDate . " +1 day"));

        // Set the target time (format: "HH:MM:SS")
        $targetTime = "00:00:00";

        // Combine the next date and target time
        $targetDateTime = $nextDate . " " . $targetTime;

        // Convert the target date and time to a Unix timestamp
        $targetTimestamp = strtotime($targetDateTime);

        // Get the current timestamp
        $currentTimestamp = time();

        // Calculate the seconds left
        $secondsLeft = $targetTimestamp - $currentTimestamp;

        return $secondsLeft;
    }

    public static function timeLeftForNextMonth() {
        // Get the current date
        $currentDate = date("Y-m-d");
    
        // Set the target date to the first day of the next month
        $nextMonthDate = date("Y-m-01", strtotime($currentDate . " +1 month"));
    
        // Set the target time (format: "HH:MM:SS")
        $targetTime = "00:00:00";
    
        // Combine the next month date and target time
        $targetDateTime = $nextMonthDate . " " . $targetTime;
    
        // Convert the target date and time to a Unix timestamp
        $targetTimestamp = strtotime($targetDateTime);
    
        // Get the current timestamp
        $currentTimestamp = time();
    
        // Calculate the seconds left
        $secondsLeft = $targetTimestamp - $currentTimestamp;
    
        return $secondsLeft;
    }
    
}