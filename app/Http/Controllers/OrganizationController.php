<?php

namespace App\Http\Controllers;

use App\User;
use App\Vacancy;
use Illuminate\Http\Request;

use App\Organization;
use Illuminate\Support\Facades\Auth;

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

        if($user->role === 'admin') {
            $organizations = Organization::all();
            return response()->json(["success" => "true", "data" => $organizations], 200);
        } else if($user->role === 'employer'){
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

        return response()->json($organization, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        $this->authorize('view', Organization::class);

        if($user->role === 'admin') {
            $organizations = Organization::find($id);
            return response()->json(["success" => "true", "data" => $organizations], 200);
        } else if($user->role === 'employer'){
            $organizations = Organization::where('id', $id)->where('user_id', $user->id)->get();
            return response()->json(["success" => "true", "data" => $organizations], 200);
        }


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
        $organization=Organization::find($id);

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
        $organization=Organization::find($id);
        $this->authorize('delete', $organization);

        Organization::find($id)->delete();
        Vacancy::where('organization_id', $organization->id)->delete();
        return response('', 204);
    }
}
