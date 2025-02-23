<?php

namespace App\Exports;

use App\Models\Exercise;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExercisesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();

        return Exercise::whereBetween('created_at', [$startOfDay, $endOfDay])->get();
    }
}
