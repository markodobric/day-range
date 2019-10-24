<?php

namespace App\Repository;

use App\User;

class MealRepository
{
    public function findByDayAndUser(Day $day, User $user)
    {
        return Meal::where('day_id', $day->id)
            ->where('user_id', $user->id)
            ->get();
    }
}
