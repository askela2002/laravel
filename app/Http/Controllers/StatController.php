<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Policies\StatPolicy;
use App\User;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function vacancies()
    {

        $this->authorize('stat', StatPolicy::class);

        $vacancies = Vacancy::all();

        $active_vacancy = 0;
        $closed_vacancy = 0;

        foreach ($vacancies as $vacancy) {
            $filed_places = DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->count();

            if ($vacancy->workers_amount > $filed_places) {
                $active_vacancy += 1;
            } else {
                $closed_vacancy += 1;
            }
        }

        $data = [
            'active' => $active_vacancy,
            'closed' => $closed_vacancy,
            'all' => $active_vacancy + $closed_vacancy,
        ];

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function organizations()
    {

        $this->authorize('stat', StatPolicy::class);

        $active_organosation = Organization::all()->count();
        $deleted_organosation = Organization::onlyTrashed()->count();

        $data = [
            'Active' => $active_organosation,
            'SoftDelete' => $deleted_organosation,
            'All' => $active_organosation + $deleted_organosation
        ];
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function users()
    {
        $this->authorize('stat', StatPolicy::class);

        $admin = User::where('role', 'admin')->count();
        $employer = User::where('role', 'employer')->count();
        $worker = User::where('role', 'worker')->count();

        $data = [
            "worker" => $worker,
            "employer" => $employer,
            "admin" => $admin
        ];

        return response()->json(['success' => true, 'data' => $data], 200);

    }
}
