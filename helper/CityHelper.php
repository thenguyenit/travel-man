<?php

namespace Helper;

class CityHelper
{
    public static $filePath = __DIR__ . '/../cities.txt';
    protected static $lines;

    /**
     * Get content from file and convert line by line to array
     */
    public static function getInstance()
    {
        if (!self::$lines) {
            if (is_file(self::$filePath)) {
                self::$lines = file(self::$filePath, FILE_IGNORE_NEW_LINES);
            } else {
                throw new \Exception('Input file "cities.txt" not found');
            }

            if (count(self::$lines) < 2) {
                throw new \Exception('Input file "cities.txt" is empty or at least two cities');
            }
        }
    }

    /**
     * Get content from file and convert to array
     *
     * @return array
     */
    public static function getCities()
    {
        self::getInstance();

        $cities = [];
        foreach (self::$lines as $line) {
            preg_match('/(.*) (.*) (.*)/', $line , $cityInfo);
            if ($cityInfo) {
                $key = strtolower(str_replace(' ', '_', $cityInfo[1]));
                $cities[$key] = [
                    'id' => $key,
                    'name' => $cityInfo[1],
                    'longitude' => floatval($cityInfo[2]),
                    'latitude' => floatval($cityInfo[3]),
                ];
            }
        }

        return $cities;
    }

    /**
     * Calculate distance cities together
     *
     * @return array
     */
    public static function getDistancesOfCities()
    {
        $result = [];
        $cities = self::getCities();
        foreach ($cities as $keyCity => $city) {
            $result[$keyCity] = $city;
            $distances = [];

            foreach ($cities as $keyTo => $to) {
                if ($keyCity != $keyTo) {
                    $to['distance'] = Distance::getDistance($city, $to);
                    $distances[] = $to;
                }
            }

            $result[$keyCity]['distances'] = $distances;
        }

        return $result;
    }

}