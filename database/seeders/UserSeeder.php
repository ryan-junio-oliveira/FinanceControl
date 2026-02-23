<?php

namespace Database\Seeders;

use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $organization = Organization::create([
            'name' => 'Default Organization',
        ]);

        // make sure permission tables exist when running seeds
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'root']);
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'gestor']);
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'member']);
        }

        // root account (not tied to any organization)
        $root = User::factory()->create([
            'username' => 'root',
            'email' => 'root@example.com',
            'password' => Hash::make('password'),
            'organization_id' => null,
        ]);
        if (method_exists($root, 'assignRole')) {
            $root->assignRole('root');
        }

        $admin = User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);
        if (method_exists($admin, 'assignRole')) {
            $admin->assignRole('gestor');
        }
    }
}
