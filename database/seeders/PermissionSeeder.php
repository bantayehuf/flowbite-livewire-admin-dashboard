<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'users' => ['manage'],
            'roles' => ['create', 'update', 'delete', 'view'],
            'departments' => ['create', 'update', 'update_own', 'delete', 'delete_own', 'view', 'view_own'],
        ];

        $permsColl = collect($permissions)->map(function ($parent, $key) {
            return collect($parent)->map(function ($perm) use ($key) {
                return ['parent' => $key, 'child' => $perm, 'name' => $perm . '_' . $key, 'guard_name' => 'web'];
            });
        })->collapse();

        foreach ($permsColl->toArray() as $perm) {
            Permission::create($perm);
        }

        // Creating super admin role
        Role::create([
            'id' => 1,
            'name' => 'Super Admin',
            'for_department' => 1,
            'created_by' => 1,
            'guard_name' => 'web',
        ]);

        $user = User::findOrFail(1);
        $user->assignRole(1);
    }
}
