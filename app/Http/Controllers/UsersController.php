<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'direction' => ['in:asc,desc'],
            'sortby' => ['in:id,name,email,is_admin']
        ]);

        return inertia('Users/Index', [
            'users' => User::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                })
                ->when($request->has('sortby', 'direction'), function ($query, $hasOrderby) {
                    $query->orderBy(request('sortby'), request('direction'));
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($user) => [
                    'avatar' => $user->avatar,
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'is_owner' => Auth::user()->id == $user->id,
                    'actions' => [
                        //'edit' => Auth::user()->can('edit', $user),
                    ]
                ]),

            'filters' => $request->only(['search', 'sortby', 'direction']),
            'can' => [
                'create' => Auth::user()->can('create', User::class),
                'edit' => Auth::user()->can('edit', User::class),
            ]
        ]);
    }

    public function create()
    {
        return inertia('Users/Create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'is_admin' => 'required|boolean',
            'password' => 'required',
        ]);

        $user = User::create($attributes);

        if ($request->file('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return redirect('/users')->with('success', 'User created.');;
    }


    public function edit(User $user)
    {
        return inertia('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'avatar' => $user->avatar,
                'deleted_at' => $user->deleted_at,
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,'.$user->id,
            'password' => 'nullable',
            'is_admin' => 'required|boolean',
            'avatar.*' => 'nullable|image'
        ]);
        
        $user->update($request->only('name', 'email', 'is_admin'));

        if ($request->file('avatar')) {
            $avatars = $request->file('avatar');
            foreach ($avatars as $key => $avatar) {
                $user->addMedia($avatar)->toMediaCollection('avatar');
            }
        }
        
        if ($request->get('password')) {
            $user->update(['password' => $request->get('password')]);
        }

        return redirect()->back()->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
