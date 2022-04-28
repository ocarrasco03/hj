<?php

namespace App\Http\Controllers\Cms\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsController extends Controller
{
    protected $guard = 'admin';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $roles, Permission $permissions)
    {
        $modules = [];

        foreach ($permissions->where('guard_name', 'admin')->orderBy('id', 'asc')->pluck('name') as $module) {
            $module = explode('.', $module);
            $module = $module[0];

            if (!$this->in_array_recursive($module, $modules, true)) {
                $modules[] = ['name' => ucfirst(str_replace('-', ' ', $module)), 'prefix' => $module];
            }
        }

        return Inertia::render('Cms/Settings/Advanced/RolesPermissions', [
            'roles' => $roles->where('guard_name', 'admin')->with('permissions')->get(),
            'permissions' => $modules,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name'],
        ]);

        DB::beginTransaction();
        try {
            $role->name = $request->name;
            $role->guard_name = $this->guard;
            $role->save();
        } catch (\Throwable$th) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
            //throw $th;
        }
        DB::commit();
        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Rol creado exitosamente!']]);
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name'],
        ]);

        $abilities = ['create', 'read', 'update', 'delete'];

        DB::beginTransaction();
        try {
            foreach ($abilities as $ability) {
                $permission = new Permission();
                $permission->name = strtolower(str_replace(' ', '-',$request->name)) . '.' . $ability;
                $permission->guard_name = $this->guard;
                $permission->save();
            }

            $superAdmin = Role::findByName('Super Administrador');
            $superAdmin->syncPermissions(Permission::all());
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
            //throw $th;
        }
        DB::commit();

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Permiso creado exitosamente!']]);
    }

    public function update(Request $request, $rol)
    {
        $request->validate([
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::where('name', $rol)->where('guard_name', $this->guard)->first();

        DB::beginTransaction();
        try {
            $role->syncPermissions($request->permissions);
        } catch (\Throwable$th) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }
        DB::commit();

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Permisos actualizados exitosamente!']]);
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
