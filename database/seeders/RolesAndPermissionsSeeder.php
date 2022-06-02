<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $modules = [
        //     'Dashboard',
        //     'Ventas',
        //     'Pedidos',
        //     'Facturas',
        //     'Devoluciones',
        //     'Catalogos',
        //     'Productos',
        //     'Paquetes',
        //     'Categorias',
        //     'Vehiculos',
        //     'Archivos',
        //     'Clientes',
        //     'Direcciones',
        //     'Servicio al Cliente',
        //     'Estadisticas',
        //     'Modulos',
        //     'Envios',
        //     'Pagos',
        //     'Soporte',
        //     'Tickets',
        //     'Logs',
        //     'Terminal',
        //     'Configuracion',
        //     'Tienda',
        //     'SEO',
        //     'Etiquetas',
        //     'Busqueda',
        //     'Slider',
        //     'Usuarios',
        //     'Permisos',
        //     'Roles',
        //     'Importar',
        //     'Exportar',
        //     'Respaldos',
        // ];

        // $abilities = ['create', 'read', 'update', 'delete'];
        // $admin = [];

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // foreach ($modules as $module) {
        //     $module = strtolower(str_replace('', '-', $module));
        //     foreach ($abilities as $ability) {
        //         Permission::create(['name' => $module . '.' . $ability, 'guard_name' => 'admin']);
        //         if (rand(0,1) === 1) {
        //             $admin[] = $module . '.' . $ability;
        //         }
        //     }
        // }

        $role = Role::create(['name' => 'Super Administrador', 'guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // create roles and assign created permissions
        // $role = Role::create(['name' => 'Administrador', 'guard_name' => 'admin'])
        //     ->givePermissionTo($admin);

    }
}
