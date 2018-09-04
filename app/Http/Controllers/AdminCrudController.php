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
        return view('backend.manage-admin', ['js' => 'manage-admin', 'menu' => 'Manage Admin']);
    }

    public function anyData()
    {
        return Datatables::of(Admin::query())->make(true);
    }

    public function checkEmail(Request $request){
        $status = 'Email already in use';
        if($request->input('id') != ""){
            $result = Admin::where('id', $request->input('id'))
                            ->where('email', $request->input('email'))
                            ->first();
            if($result != null){
                $status = "true";
            }else{
                $result = Admin::where('email', $request->input('email'))->first();
                if($result == null){
                    $status = "true";
                }
            }
        }else{
            $result = Admin::where('email', $request->input('email'))->first();
            if($result == null){
                $status = "true";
            }
        }
        return response()->json($status);
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

    public function resetPassword(Request $request){
        $update = Admin::where("id", $request->input('id'))->update(array(
            'password' => Hash::make("12345678"),
        ));

        return response()->json($update);
    }
}
