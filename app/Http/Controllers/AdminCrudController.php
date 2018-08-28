<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin as Admin;
use Yajra\Datatables\Datatables;

class AdminCrudController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin-crud', ['js' => 'admin-crud', 'menu' => 'Dashboard']);
    }

    public function anyData()
    {
        return Datatables::of(Admin::query())->make(true);
    }
}
