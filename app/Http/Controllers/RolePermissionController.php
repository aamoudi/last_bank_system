<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($roleId)
    {
        //
        $permissions = Permission::where('guard_name', 'user')->get();
        $role = Role::findById($roleId, 'user');

        if ($role->permissions->count() > 0) {
            foreach ($permissions as $permission) {
                $permission->setAttribute('is_active', false);
                if ($role->hasPermissionTo($permission)) {
                    $permission->setAttribute('is_active', true);
                }
            }
        }
        return response()->view('cms.spatie.roles.index-permissions', ['roleId' => $roleId, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $roleId)
    {
        //
        $validator = Validator($request->all(), [
            'permission_id' => 'required|exists:permissions,id|numeric',
        ]);

        if (!$validator->fails()) {
            $permission = Permission::findById($request->get('permission_id'), 'user');
            $role = Role::findById($roleId, 'user');
            if ($role->hasPermissionTo($permission))
                $isSaved = $role->revokePermissionTo($permission);
            else
                $isSaved = $role->givePermissionTo($permission);
            return response()->json(['message' => $isSaved ? 'Permission assigned successfully' : "Failed to assign permission"], $isSaved ? 200 : 400);
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
    }
}
