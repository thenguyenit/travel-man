<?php

class DistanceTest extends PHPUnit_Framework_TestCase
{
    public function testGetDistanceValid()
    {
        $fromCity = [
            'id' => 'hochiminh',
            'name' => 'Ho Chi Minh',
            'longitude' => 10.7680339,
            'latitude' => 106.4141801
        ];

        $toCity = [
            'id' => 'marid',
            'name' => 'Marid',
            'longitude' => 40.4378698,
            'latitude' => -3.819619
        ];

        $distance = \Helper\Distance::getDistance($fromCity, $toCity);
        $this->assertTrue($distance >=0);
    }
}
