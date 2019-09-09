<?php

namespace App\Http\Controllers;

use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function book(Request $request)
    {

        $user = Auth::user();
        $vacancy = Vacancy::find($request->vacancy_id);



        $bookingsAmount = DB::table('bookings')->where('vacancy_id', $request->vacancy_id)->count();

//        dd($bookingsAmount, $vacancy->workers_amount);

        if (($user->id === $request->user_id || $user->role === 'admin') && $vacancy->workers_amount > $bookingsAmount) {
            DB::table('bookings')
                ->updateOrInsert(
                    ['user_id' => $request->user_id, 'vacancy_id' => $request->vacancy_id, 'created_at'=> now()]
                );

            return response()->json(["success" => true, 'data'=>'Booking has been added!'], 200);
        }

    }

    public function unbook(Request $request)
    {

        $user = Auth::user();
        $vacancy = Vacancy::find($request->vacancy_id);


        if (($user->id === $request->user_id || $user->role === 'admin') && $vacancy) {

            DB::table('bookings')->where('user_id',$request->user_id)->where('vacancy_id', $request->vacancy_id)->delete();

            $vacancy->workers_amount =  $vacancy->workers_amount + 1;

            $vacancy->save();

            return response()->json(["success" => true, 'data'=>'Booking has been deleted!'], 200);
        }

    }


}
