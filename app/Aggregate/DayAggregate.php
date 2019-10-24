<?php

namespace App\Aggregate;

use App\Day;

class DayAggregate
{
    private $day;

    public function __construct(Day $day)
    {
        $this->day = $day;
    }

    public function map()
    {
        return [
            'id' => $this->day->id,
            'date' => $this->day->date,
            'calorie_limit' => $this->day->calorie_limit,
            'total_calories' => $this->getTotalCalories($this->day),
            'meals' => $this->day->meals->all(),
        ];
    }

    private function getTotalCalories(Day $day)
    {
        $total = 0;

        foreach ($day->meals as $meal) {
            $total += $meal->calories;
        }

        return $total;
    }
}
