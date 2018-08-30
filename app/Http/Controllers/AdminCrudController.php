<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('backend.admin-crud', ['js' => 'admin-crud', 'menu' => 'Admin CRUD']);
    }

    public function anyData()
    {
        return Datatables::of(Admin::query())->make(true);
    }

    public function add(Request $request){
        $add = Admin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json($add);
    }

    public function update(Request $request){
        $update = Admin::where("id", $request->input('id'))->update(array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ));

        return response()->json($update);
    }

    public function delete(Request $request){
        $delete = Admin::where("id", $request->input('id'))->delete();
        return response()->json($delete);
    }
}
