<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::withCount('permissions')->paginate(10);
        return response()->view('cms.spatie.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.spatie.roles.create');
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
            'guard' => 'required|string|in:admin,user',
            'name' => 'required|string|min:3'
        ]);

        if (!$validator->fails()) {
            $role = new Role();
            $role->name = $request->get('name');
            $role->guard_name = $request->get('guard');
            $isSaved = $role->save();
            return response()->json(['message' => $isSaved ? 'Role created succssefully' : "Failed to create roles"], $isSaved ? 200 : 400);
        } else {
            return response()->json(['message' => 'Please check required data'], 400);
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
        $role = Role::findById($id, 'admin');
        return response()->view('cms.spatie.roles.edit', ['role' => $role]);
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
            'guard' => 'required|string|in:admin,user',
            'name' => 'required|string|min:3'
        ]);

        if (!$validator->fails()) {
            $role = Role::findOrFail($id);
            $role->name = $request->get('name');
            $role->guard_name = $request->get('guard');
            $isSaved = $role->save();
            return response()->json(['message' => $isSaved ? 'Role updated succssefully' : "Failed to update roles"], $isSaved ? 200 : 400);
        } else {
            return response()->json(['message' => 'Please check required data'], 400);
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
        $isDeleted = Role::destroy($id);
        if ($isDeleted) {
            return response()->json(['title' => 'Deleted!', 'message' => 'Role Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete role failed', 'icon' => 'error'], 400);
        }
    }
}
