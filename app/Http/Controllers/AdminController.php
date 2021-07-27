<?php

namespace App\Http\Controllers;

use App\Mail\NewAdminWelcomeEmail;
use App\Models\Admin;
use App\Models\City;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        /**
         *Num OF Rows = 100;
         * Pagination = 10=> 100/10 = 10 Pages
         */
        // $admins = Admin::paginate(10);
        $admins = Admin::withCount('permissions')->with(['city'])->paginate(10);
        $admin = Admin::find(1);
        // $admin->hasPermission();
        return response()->view('cms.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cities = City::where('active', true)->get();
        return response()->view('cms.admins.create', ['cities' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|numeric|digits:10|unique:admins,mobile',
            'gender' => 'required|in:M,F|string'
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->city_id = $request->get('city_id');
            $admin->gender = $request->get('gender');
            $admin->password = Hash::make('Pass123$');
            $isSaved = $admin->save();

            if ($isSaved) {
                // Mail::to($admin)->send(new NewAdminWelcomeEmail($admin));
                // Mail::to($admin)->queue(new NewAdminWelcomeEmail($admin));
                // event(new Registered($admin));
            }
            return response()->json(['message' => $isSaved ? 'Admin created successfully' : 'Failed to create admin!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $admin = Admin::findOrFail($id);
        $cities = City::where('active', true)->get();
        return response()->view('cms.admins.edit', ['cities' => $cities, 'admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'city_id' => 'required|numeric|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:admins,email,' . $id,
            'mobile' => 'required|string|unique:admins,mobile,' . $id,
            'gender' => 'required|string|in:M,F'
        ]);

        if (!$validator->fails()) {
            $admin = Admin::findOrFail($id);
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->city_id = $request->get('city_id');
            $admin->gender = $request->get('gender');
            $isSaved = $admin->save();
            return response()->json(['message' => $isSaved ? 'Admin updated successfully' : 'Failed to create admin!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $isDeleted = Admin::destroy($id);
        if ($isDeleted) {
            return response()->json(['title' => 'Deleted!', 'message' => 'Currency Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete currency failed', 'icon' => 'error'], 400);
        }
    }
}
