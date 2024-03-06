<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function create(House $house)
    {
        return view('complaint.create',compact('house'));
    }
    public function save(Request $request,House $house)
    {
        $user = $house->user->first();
        $flag = $this->complaintsCheck($user);
        if ($flag){
            return redirect()->back();
        }
        $validated = $this->validation($request);
        $validated['sender_id']=Auth::user()->id;
        $user->complaints()->create($validated);
        $house->complaintCounter();
        return redirect()->back();
    }
    private function validation(Request $request)
    {
        return $request->validate(['text'=>'required']);
    }
    private function complaintsCheck(User $user)
    {
        $user = Auth::user();
        $date=now()->toDateString();
        $complaints = $user->sendedComplaints()->where(DB::raw('DATE(created_at)'),'=',$date)->where('user_id','=',$user->id)->get();
        if ($complaints->isNotEmpty()){
            session()->flash('message','Вы уже жаловались на этого пользователя сегодня');
            return true;
        }
        return false;
    }
}
