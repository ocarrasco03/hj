<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(YearSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(StatusSeeder::class);
        $admin = \App\Models\Cms\Admin::factory()->create(['name'=> 'Oscar Carrasco', 'username' => 'ocarrasco', 'email' => 'ocarrasco@hjautopartes.com.mx']);
        $admin->syncRoles('Super Administrador');
        \App\Models\Cms\Admin::factory(10)->create();
        \App\Models\User::factory()->create(['name'=> 'Oscar Carrasco', 'email' => 'ocarrasco@hjautopartes.com.mx']);
        \App\Models\User::factory(10)->create();
        // \App\Models\Sales\Order::factory(100)->create();
    }
}
