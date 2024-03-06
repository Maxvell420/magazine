<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\City;
use App\Models\House;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class RoleController extends Controller
{
    public function __construct(protected AdminService $adminService)
    {}

    public function statistics()
    {
        if (empty($date)){
            $date = now()->toDateString();
        }
        $usersNewChats = $this->adminService->getUsersWithNewChatsByDate();
        $usersNewHouses = $this->adminService->getUsersWithNewHousesByDate();
        return view('admin.statistics',compact(['usersNewHouses','usersNewChats','date']));
    }
    public function frozen()
    {
        $users = $this->adminService->getFrozenUsers();
        return view('admin.frozen',compact('users'));
    }
    public function userBan(User $user)
    {
        $this->adminService->banUser($user);
        return redirect()->back();
    }
    public function userUnfreeze(User $user)
    {
        $this->adminService->userUnfreeze($user);
        return redirect()->back();
    }
}
