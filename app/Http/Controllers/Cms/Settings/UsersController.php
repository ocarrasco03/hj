<?php

namespace App\Http\Controllers\Cms\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Settings\Advanced\UserRequest;
use App\Http\Requests\Cms\Settings\Advanced\UserUpdateRequest;
use App\Http\Resources\Cms\Settings\Advanced\UserCollection;
use App\Http\Resources\Cms\Settings\Advanced\UserResource;
use App\Models\Cms\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Admin $users)
    {
        if ($request->has('query') && strlen($request['query']) > 0) {
            $users = $users->search($request->input('query'))->withTrashed()->paginate(15);
        } else {
            $users = $users->withTrashed()->with('roles')->paginate(15);
        }

        return Inertia::render('Cms/Settings/Advanced/Users', ['users' => new UserCollection($users)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = [];
        $modules = [];

        foreach (Role::where('guard_name', 'admin')->get() as $role) {
            $roles[] = ['name' => $role->name, 'abilities' => $role->permissions->pluck('name')];
        }

        foreach (Permission::where('guard_name', 'admin')->orderBy('id', 'asc')->pluck('name') as $module) {
            $module = explode('.', $module);
            $module = $module[0];

            if (!$this->in_array_recursive($module, $modules, true)) {
                $modules[] = ['name' => ucfirst(str_replace('-', ' ', $module)), 'prefix' => $module];
            }
        }

        return Inertia::render('Cms/Settings/Advanced/Users/Create', ['roles' => $roles, 'modules' => $modules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = new Admin();
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $user->syncRoles($request->input('role'));

            if ($request->input('role') !== 'Super Administrador') {
                $user->syncPermissions($request->input('permissions'));
            }

            if ($request->hasFile('avatar')) {
                $user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            DB::commit();
        } catch (\Throwable$th) {
            // throw $th;
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect(route('admin.settings.advanced.users.index'))->with(['toast' => ['type' => 'success', 'message' => 'Usuario creado exitosamente!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cms\Admin  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $id)
    {
        $roles = [];
        $modules = [];
        $user = [];

        foreach (Role::where('guard_name', 'admin')->get() as $role) {
            $roles[] = ['name' => $role->name, 'abilities' => $role->permissions->pluck('name')];
        }

        foreach (Permission::where('guard_name', 'admin')->orderBy('id', 'asc')->pluck('name') as $module) {
            $module = explode('.', $module);
            $module = $module[0];

            if (!$this->in_array_recursive($module, $modules, true)) {
                $modules[] = ['name' => ucfirst(str_replace('-', ' ', $module)), 'prefix' => $module];
            }
        }

        return Inertia::render('Cms/Settings/Advanced/Users/Edit', ['roles' => $roles, 'modules' => $modules, 'user' => new UserResource($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Cms\Settings\Advanced\UserRequest  $request
     * @param  \App\Models\Cms\Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, Admin $user)
    {
        DB::beginTransaction();
        try {
            foreach ($request->input() as $key => $value) {
                if ($user->$key !== $value && $key !== 'role' && $key !== 'permissions') {
                    if ($key === 'username' || $key === 'email') {
                        $request->validate([
                            'username' => ['unique:admins,username'],
                            'email' => ['unique:admins,email'],
                        ]);
                    }
                    $user->$key = $value;
                }
            }

            if ($request->hasFile('avatar')) {
                if ($user->getMedia('avatar')->count() > 0) {
                    $media = $user->getMedia('avatar');
                    $user->clearMediaCollection('avatar');
                }
                $user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            if ($user->isDirty()) {
                $user->save();
            }

            if (!$user->hasRole($request->input('role'))) {
                $user->syncRoles($request->input('role'));
            }

            if ($request->input('role') !== 'Super Administrador') {
                $user->syncPermissions($request->input('permissions'));
            }
        } catch (\Throwable$th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
        DB::commit();

        return redirect(route('admin.settings.advanced.users.index'))->with(['toast' => ['type' => 'success', 'message' => 'Usuario actualizado']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
        } catch (\Throwable$th) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => true, 'message' => 'El usuario ' . $user->name . 'ha sido eliminado exitosamente']);
    }

    public function restore($user)
    {
        DB::beginTransaction();
        try {
            $user = Admin::withTrashed()->find($user);
            $user->restore();
        } catch (\Throwable$th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
        return redirect()->back();
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with(['toast' => ['type' => 'success', 'message' => __($status)]]);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    /**
     * Checks if a value exists in an array
     *
     * @param mixed $needle
     * @param array $haystack
     * @param boolean $strict
     * @return boolean
     */
    public function in_array_recursive(mixed $needle, array $haystack, bool $strict = false): bool
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_recursive($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
}
