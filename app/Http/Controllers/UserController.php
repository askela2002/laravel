<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Vacancy;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $search = $request->search;

        if ($search) {
            $users = User::where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('country', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%')
                ->get();
        } else {
            $users = User::all();
        }
        return response()->json(["success" => "true", "data" => $users], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $this->authorize('view', $user);


        return response()->json(["success" => "true", "data" => $user], 200);
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
        $user = User::find($id);

        $this->authorize('update', $user);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $user->update($data);

        return response()->json(["success" => "true", "data" => User::find($id)], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $this->authorize('delete', $user);
        $user->api_token = Null;
        $user->save();

        $organizations = Organization::where('user_id', $id)->get();

        foreach ($organizations as $organization) {
            $vacancies = Vacancy::where('organization_id', $organization->id)->get();

            foreach ($vacancies as $vacancy) {
                DB::table('user_vacancy')->where('vacancy_id', $vacancy->id)->update(array('deleted_at' => DB::raw('NOW()')));;
            }
            $vacancies->each->delete();
        }

        DB::table('user_vacancy')->where('user_id', $user->id)->update(array('deleted_at' => DB::raw('NOW()')));;
        $organizations->each->delete();
        $user->delete();
        return response('', 200);
    }
}
