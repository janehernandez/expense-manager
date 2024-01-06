<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderByDesc('created_at')->get();
        return Inertia::render('UserManagement/Role/Index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->validated());
        return back()->with([
            'message' => 'success|Role has been created.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return back()->with('message', 'success|Role has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Check if Role is being attached or being used by the user
        $users = User::whereHas('roles', function ($q) use ($role) {
            $q->whereIn('roles.name', [$role->name]);
        })->get();

        //if the role specified is attached to the user, do not delete
        if (!$users->isEmpty()) {
            return back()->with('message', 'warning|There are users who are using this role. Deleting is not allowed.');
        }

        $role->delete();
        return back()->with('message', 'success|Role has been deleted.');
    }
}
