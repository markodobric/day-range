<?php

declare(strict_type=1);

namespace App\Service;

use App\Aggregate\DayAggregate;
use App\Repository\DayRepository;
use App\Repository\MealRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DayService
{
    /**
     * @var DayRepository
     */
    private $dayRepository;

    /**
     * @var MealRepository
     */
    private $mealRepository;

    public function __construct(
        DayRepository $dayRepository,
        MealRepository $mealRepository
    )
    {
        $this->dayRepository = $dayRepository;
        $this->mealRepository = $mealRepository;
    }

    public function getDaysCollection(
        Carbon $startDate,
        Carbon $endDate,
        User $user
    ): Collection
    {
        $collection = new Collection();

        $days = $this->dayRepository->findByDateRangeAndUser($startDate, $endDate, $user);
        foreach ($days as &$day) {
            $day->meals = $this->mealRepository->findByDayAndUser($day, $user);
            $collection->add(
                (new DayAggregate($day))->map()
            );
        }

        return $collection;
    }
}
