<?php

class KernelTest extends PHPUnit_Framework_TestCase
{
    public function testShortestRoadValid()
    {
        $kernel = new \App\Kernel();
        $shortestRoad = $kernel->findShortestRoad();

        //Check return format valid
        $this->assertTrue(isset($shortestRoad['cities']) && isset($shortestRoad['meter']));

        //Check total city on the road
        $totalCityFromFileInput = count(\Helper\CityHelper::getCities());
        $this->assertEquals(count($shortestRoad['cities']), $totalCityFromFileInput);
    }
}
