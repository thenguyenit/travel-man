<?php

namespace App;

use Helper\CityHelper;

class Kernel
{
    protected $cities;
    protected $road;
    protected $totalCity;

    /**
     * The main action of the application
     */
    public function handle()
    {
        $shortestRoad = $this->findShortestRoad();

        //Print result
        echo implode("\n", $shortestRoad['cities']);
    }

    /**
     * Find a shortest road
     *
     * @return array
     */
    public function findShortestRoad()
    {
        $allRoadCanGo = [];

        $this->cities = CityHelper::getDistancesOfCities();
        $this->totalCity = count($this->cities);

        foreach ($this->cities as $start) {
            //Choose a city to start
            $this->road = [
                'cities' => [
                    $start['name']
                ],
                'meter' => 0
            ];
            $this->findNextCity($start);
            $allRoadCanGo[] = $this->road;
        }

        /**
         * Find a final road which has shortest distance
         */
        //Short distance from low to high of the roads
        usort($allRoadCanGo, function ($item1, $item2) {
            if ($item1['meter'] == $item2['meter']) return 0;
            return $item1['meter'] < $item2['meter'] ? -1 : 1;
        });

        return current($allRoadCanGo);
    }

    /**
     * Find a next city to go
     *
     * @param $startPoint
     */
    private function findNextCity($startPoint)
    {
        //Get all distances from $startPoint to all of cities
        $distances = $this->cities[$startPoint['id']]['distances'];

        //Sort distance from low to high then get shortest distance
        usort($distances, function ($item1, $item2) {
            if ($item1['distance'] == $item2['distance']) return 0;
            return $item1['distance'] < $item2['distance'] ? -1 : 1;
        });

        //Find a next city which have shortest distance and without in the road
        $nextCity = current($distances);
        while (in_array($nextCity['name'], $this->road['cities'])) {
            $nextCity = next($distances);
        }

        //Push city to the road
        $this->road['cities'][] = $nextCity['name'];
        $this->road['meter'] += $nextCity['distance'];

        //Continue find a next city which have shortest distance
        if (count($this->road['cities']) < $this->totalCity) {
            $this->findNextCity($nextCity);
        }
    }
}