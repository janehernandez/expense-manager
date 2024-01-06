<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles:name,id'])
            ->orderByDesc('id')
            ->get();
        $roles = Role::all();

        return Inertia::render('UserManagement/User/Index', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                // default password should be password
                'password' => bcrypt('password'),
                ...Arr::except($request->validated(), 'role_id')
            ]);

            $role = Role::whereId($request->role_id)->first();
            $user->roles()->attach($role);

            event(new Registered($user));
        });

        return back()->with('message', 'success|New User has been added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            // remove first the role assigned to the user
            $user->roles()->detach();

            // update the user except for its role id
            $user = tap($user)->update(Arr::except($request->validated(), 'role_id'));

            // attach the role again with the role_id specified
            $role = Role::whereId($request->role_id)->first();
            $user->roles()->attach($role);
        });

        return back()->with('message', 'success|User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return back()->with('message', 'success|User has been removed');
    }
}
