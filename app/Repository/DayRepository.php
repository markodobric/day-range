<?php

namespace App\Repository;

use App\User;
use Carbon\Carbon;

class DayRepository
{
    public function findByDateRangeAndUser(Carbon $min, Carbon $max, User $user)
    {
        return Day::where([
            ['date', '>=', $min->format('Y-m-d')],
            ['date', '<=', $max->format('Y-m-d')],
            ['user_id', '=', $user->id],
        ])
            ->orderBy('date', 'ASC')
            ->get();
    }
}
