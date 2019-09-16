<?php

namespace App\Http\Controllers;

use App\Organization;
use App\User;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VacancyController extends Controller
{
    public function book(Request $request)
    {
        $user = User::find($request->user_id);

        $this->authorize('book', [Vacancy::class, $user]);

        $vacancy = Vacancy::find($request->vacancy_id);


        if ($vacancy && $user) {

            $workers_amount = $vacancy->workers_amount;

            $bookings_amount = DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->count();

            if ($workers_amount > $bookings_amount) {

                $user->vacancies()->attach($vacancy);

                return response()->json(["success" => true, 'data' => 'Booking has been added!'], 200);
            } else {
                return response()->json(["success" => false, 'data' => 'There are no vacancies available!'], 400);
            }
        } else {
            return response()->json(["success" => false, 'data' => 'There is no such user or such vacancy!'], 400);
        }

    }


    public function unbook(Request $request)
    {
        $user = User::find($request->user_id);

        $this->authorize('unbook', [Vacancy::class, $user]);

        $vacancy = Vacancy::find($request->vacancy_id);

        $booking_exist = DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->where('user_id', $user->id)->count();

        if ($booking_exist === 1) {

            $user->vacancies()->detach($vacancy);

            return response()->json(["success" => true, 'data' => 'Booking has been deleted!'], 200);
        } else {
            return response()->json(["success" => false, 'data' => 'There is no such user or such vacancy!'], 400);
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user();

        $this->authorize('viewAny', Vacancy::class);

        $vacancies = Vacancy::all();
        $vacancies_active = [];

        if ($user->role === 'admin' && $request->only_active === "false") {

            return response()->json(["success" => "true", "data" => $vacancies], 200);
        } else {
            foreach ($vacancies as $vacancy) {
                $places_booked = DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->count();

                if ($vacancy->workers_amount > $places_booked) {
                    array_push($vacancies_active, $vacancy);
                }
            }

            return response()->json(["success" => "true", "data" => $vacancies_active], 200);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organization_id = $request->organization_id;

        $this->authorize('create', [Vacancy::class, $organization_id]);

        $vacancy = Vacancy::create($request->all());

        return response()->json(['success' => true, 'data' => $vacancy], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Vacancy::class);

        $vacancy = Vacancy::find($id);

        return response()->json(['success' => true, 'data' => $vacancy], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->authorize('update', Vacancy::class);

        $user = Auth::user();
        $vacancy = Vacancy::find($id);


        if ($user->role === 'admin' || ($user->role === 'employer' && $user->id === Organization::find($vacancy->organization_id)->user_id)) {
            $vacancy->update($request->all());

            return response()->json(["success" => "true", "data" => Vacancy::find($id)], 201);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Vacancy::class);

        $user = Auth::user();
        $vacancy = Vacancy::find($id);


        if ($user->role === 'admin' || ($user->role === 'employer' && $user->id === Organization::find($vacancy->organization_id)->user_id)) {
            $vacancy->delete();

            return response('', 204);
        }

        return response()->json(["success" => "false", "data" => 'Nothing was deleted!'], 400);

    }
}
