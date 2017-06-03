<?php
namespace Helper;

class Distance
{
    /**
     * Calculates the great-circle distance between two points, with
     * the Vincenty formula.
     * @param array $from Mean start point
     * @param array $to Mean end point
     * @param int $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m]
     */
    public static function getDistance($from, $to, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad(isset($from['latitude']) ? $from['latitude'] : 0);
        $lonFrom = deg2rad(isset($from['longitude']) ? $from['longitude'] : 0);
        $latTo = deg2rad(isset($to['latitude']) ? $to['latitude'] : 0);
        $lonTo = deg2rad(isset($to['longitude']) ? $to['longitude'] : 0);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        return $angle * $earthRadius;
    }
}