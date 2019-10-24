<?php

namespace App\Http\Controllers\API;

use App\Service\DayService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DayController extends Controller
{
    /**
     * @var DayService
     */
    private $dayService;

    public function __construct(DayService $dayService)
    {
        $this->dayService = $dayService;
    }

    public function getDayRange(
        $startDate,
        $endDate
    )
    {
        $validator = Validator::make(['start_date' => $startDate, 'end_date' => $endDate], [
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()
            ->json(
                (
                    $this->dayService->getDaysCollection(
                        new Carbon($startDate),
                        new Carbon($endDate),
                        auth()->user()
                    )
                )
                    ->all()
            );
    }
}
