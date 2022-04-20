<?php

namespace App\Http\Controllers\Cms\Settings;

use App\Http\Controllers\Controller;
use App\Models\Cms\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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
    public function index(Request $request)
    {
        if (!is_null($request->input('query'))) {
            $users = Admin::search($request->input('query'))->withTrashed()->paginate(15);
        } else {
            $users = Admin::withTrashed()->paginate(15);
        }

        $users->load('roles');

        return Inertia::render('Cms/Settings/Advanced/Users', ['users' => $users]);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'unique:admins,username', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8', Password::defaults()],
            'role' => ['required', 'string'],
        ]);

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

            DB::commit();
        } catch (\Throwable$th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect(route('admin.settings.advanced.users.index'));
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

        $user = $id->toArray();
        $user['role'] = count($id->getRoleNames()) > 0 ? $id->getRoleNames()[0] : null;
        $user['permissions'] = $id->getAllPermissions()->pluck('name');

        return Inertia::render('Cms/Settings/Advanced/Users/Edit', ['roles' => $roles, 'modules' => $modules, 'user' => $user]);
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
