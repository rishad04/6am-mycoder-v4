<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Todo;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Models\AdminActivity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Spatie\Activitylog\Models\Activity;
use Spatie\Analytics\Facades\Analytics;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(Request $req)
    {

        $admin = Admin::where('id', Auth::id())->first();
        // $admin->visit()->withSession();

        $page_title       = 'Dashboard';
        $page_description = 'This is the base Admin Panel of Tork';

        return view('backend.dashboard', compact('admin'));
    }
}
