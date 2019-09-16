<?php

namespace App\Http\Controllers;

use App\User;
use App\Vacancy;
use Illuminate\Http\Request;

use App\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = Auth::user();

        $this->authorize('viewAny', Organization::class);

        if ($user->role === 'admin') {
            $organizations = Organization::all();
            return response()->json(["success" => "true", "data" => $organizations], 200);
        } else if ($user->role === 'employer') {
            $organizations = Organization::where('user_id', $user->id)->get();
            return response()->json(["success" => "true", "data" => $organizations], 200);
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

        $this->authorize('create', Organization::class);

        $organization = $request->all();
        $organization['user_id'] = Auth::id();
        Organization::create($organization);

        return response()->json(['success' => true, 'data' => $organization], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $organization = Organization::find($id);

        $this->authorize('view', [Organization::class, $organization]);

        $data = $organization;
        $data->creator = User::find($organization->user_id);

        if ($request->vacancies === "1" || $request->vacancies === "2" || $request->vacancies === "3" || $request->workers === "1") {

            $vacancies = Vacancy::where('organization_id', $organization->id)->get();

            $workers = [];
            $vacancies_active = [];
            $vacancies_closed = [];

            foreach ($vacancies as $vacancy) {

                $db_request = DB::select('select user_id from user_vacancy where vacancy_id = :vacancy_id', ['vacancy_id' => $vacancy->id]);

                if ($request->vacancies === "1" || $request->vacancies === "2" || $request->vacancies === "3") {

                    $places_booked = count($db_request);

                    $vacancy->wokers_booked = $places_booked;

                    if ($vacancy->workers_amount > $places_booked) {
                        $vacancy->status = 'active';
                        array_push($vacancies_active, $vacancy);
                    } else {
                        $vacancy->status = 'closed';
                        array_push($vacancies_closed, $vacancy);
                    }

                    if ($request->vacancies === "3") {
                        $data->vacancies = array_merge($vacancies_closed, $vacancies_active);
                    } elseif ($request->vacancies === "2") {
                        $data->vacancies = $vacancies_closed;
                    } elseif ($request->vacancies === "1") {
                        $data->vacancies = $vacancies_active;
                    }
                }

                if ($request->workers === "1") {
                    foreach ($db_request as $worker) {
                        array_push($workers, User::find($worker->user_id));
                    }
                    $data->workers = $workers;
                }
            }
        }

        return response()->json(["success" => "true", "data" => $data], 200);
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
        $organization = Organization::find($id);

        $this->authorize('update', $organization);

        $organization->update($request->all());

        return response()->json(["success" => "true", "data" => Organization::find($id)], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        $this->authorize('delete', [Organization::class, $organization]);

        $vacancies = Vacancy::where('organization_id', $organization->id)->get();

        foreach ($vacancies as $vacancy){
            DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->delete();
        }

        $organization->delete();
        $vacancies->each->delete();

        return response('', 204);
    }
}
