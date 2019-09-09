<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user();

        $this->authorize('viewAny', Vacancy::class);

        if ($user->role === 'admin' && $request->only_active === "false") {
            $vacancies = Vacancy::all();
            return response()->json(["success" => "true", "data" => $vacancies], 200);
        } else {
            $vacancies = Vacancy::where('workers_amount', '>', 0)->get();
            return response()->json(["success" => "true", "data" => $vacancies], 200);
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
        $user = Auth::user();
        $this->authorize('create', Vacancy::class);

        $organizations = Organization::where('user_id', $user->id)->get();

        foreach ($organizations as $organization) {
            if ($request->organization_id === $organization->id) {
                $vacancy = Vacancy::create($request->all());

                return response()->json(['success' => true, 'data' => $vacancy], 201);
            }
        }

        return response()->json(['success' => false, 'data' => 'You don`t own this organization!'], 400);
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

        $user=Auth::user();
        $vacancy=Vacancy::find($id);



        if($user->role === 'admin'){
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
        //
    }
}
