<?php

namespace App\Http\Controllers;

use App\Policies\StatPolicy;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function vacancy()
    {

        $this->authorize('stat', StatPolicy::class);

        $vacancies = Vacancy::all();
        $all = $vacancies->count();

        $open_vacancy = 0;
        $closed_vacancy = 0;

        foreach ($vacancies as $vacancy) {
            $filed_places = DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->count();

            if($vacancy->workers_amount > $filed_places){
                $open_vacancy += 1;
            } else {
                $closed_vacancy += 1;
            }
        }


        $data = [
            'all' => $all,
            'open' => $open_vacancy,
            'closed' => $closed_vacancy
        ];

        return response()->json(['success' => true, 'data' => $data], 200);

    }
}
