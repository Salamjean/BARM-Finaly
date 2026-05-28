<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function personals()
    {
        //$users = User::withTrashed()->get();

        $personals = Personnel::onlyTrashed()->with('user', function($query){
            $query->onlyTrashed()->get();
        })->get();

        return view('dashboard.trash.trash-personals', ['personals' => $personals]);
    }

    public function restorePerosnal(int $id)
    {

        Personnel::withTrashed()->where('id', $id)->restore();
        $personal = Personnel::findOrFail($id);
        User::withTrashed()->where('id', $personal->user_id)->restore();
        $user = User::findOrFail($personal->user_id);
        $user->update(['status' => '1']);

        if ($personal->death == '1')
            $personal->update([
                'death' => '0',
                'death_date' => null,
                'death_no_act' => null,
                'death_city' => null,
                'death_justification' => null,
            ]);

        return to_route('personnel.index')->with('success', 'Personnel is restored successfully');
    }
}
