<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Call;

class UsersController extends Controller
{
    public function index()
    {
        $users = 'test';
        $users = User::with('calls')->get();
        return view('users', ['users' => $users]);
    }

    public function user($id)
    {
        $user = User::where('id', $id)->with('calls')->get();

        $data_week = Call::where('user_id', $user[0]['id'])->whereBetween('date', array(Carbon::now()->subDays(7), Carbon::now()))->orderBy('date', 'asc')->get();

        $data_month = Call::where('user_id', $user[0]['id'])->whereBetween('date', array(Carbon::now()->subDays(31), Carbon::now()))->orderBy('date', 'asc')->get();

        $weeklyQuotes = $data_week->groupBy(function($item) {
            return Carbon::createFromFormat('Y-m-d h:i:s', $item->date)->format('Y-m-d');
        });

        $monthlyQuotes = $data_month->groupBy(function($item) {
            return Carbon::createFromFormat('Y-m-d h:i:s', $item->date)->format('Y-m-d');
        });

        $weekly_durations = $weeklyQuotes->map(function ($item, $key) {
          return [$key => $item->sum('duration')];
        });

        $weekly_score = $weeklyQuotes->map(function ($item, $key) {
          return [$key => round($item->avg('call_score'))];
        });

        $monthly_durations = $monthlyQuotes->map(function ($item, $key) {
          return [$key => $item->sum('duration')];
        });

        $monthly_score = $monthlyQuotes ->map(function ($item, $key) {
          return [$key => round($item->avg('call_score'))];
        });

        return view('user', ['user' => $user, 'weekly_durations' => $weekly_durations, 'weekly_scores' => $weekly_score, 'monthly_durations' => $monthly_durations, 'monthly_scores' => $monthly_score]);
    }
}
