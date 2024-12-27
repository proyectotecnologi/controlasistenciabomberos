<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // El sistema va tener 2 roles
        // Administrador
        // Secretaria
        $admin = Role::create(['name' => 'admin']);
        $secretaria = Role::create(['name' => 'secretaria']);
        $jefe_recursos_humanos = Role::create(['name' => 'jefe_recursos_humanos']);
        $jefe_planeamiento_operaciones = Role::create(['name' => 'jefe_planeamiento_operaciones']);

        Permission::create(['name' => 'reportes'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'pdf'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'pdf_fechas'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'reportesmiembros'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'pdfmiembros'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'pdf_fechas_miembros'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'index'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'home'])->syncRoles([$admin, $secretaria, $jefe_recursos_humanos, $jefe_planeamiento_operaciones]);
        Permission::create(['name' => 'miembros'])->syncRoles([$admin, $jefe_recursos_humanos]);
        Permission::create(['name' => 'divisions'])->syncRoles([$admin, $jefe_recursos_humanos]);
        Permission::create(['name' => 'usuarios'])->syncRoles([$admin, $jefe_recursos_humanos]);
        Permission::create(['name' => 'asistencias'])->syncRoles([$admin, $jefe_recursos_humanos]);

        User::find(1)->assignRole($admin);
        User::find(2)->assignRole($secretaria);
        User::find(3)->assignRole($jefe_recursos_humanos);
        User::find(4)->assignRole($jefe_planeamiento_operaciones);

    }
}
