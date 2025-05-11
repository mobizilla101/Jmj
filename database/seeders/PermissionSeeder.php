<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lists = config('abilities');

        foreach ($lists as $list) {
            Permission::firstOrCreate(
                ['name' => 'view.' . $list],
                [
                    'title' => 'View ' . ucfirst($list),
                    'description' => 'Can View ' . ucfirst($list),
                ]
            );

            Permission::firstOrCreate(
                ['name' => 'create.' . $list],
                [
                    'title' => 'Create ' . ucfirst($list),
                    'description' => 'Can Create ' . ucfirst($list),
                ]
            );

            Permission::firstOrCreate(
                ['name' => 'update.' . $list],
                [
                    'title' => 'Update ' . ucfirst($list),
                    'description' => 'Can Update ' . ucfirst($list),
                ]
            );

            Permission::firstOrCreate(
                ['name' => 'delete.' . $list],
                [
                    'title' => 'Delete ' . ucfirst($list),
                    'description' => 'Can Delete ' . ucfirst($list),
                ]
            );
        }
        Permission::firstOrCreate(
            ['name' => 'view.permission'],
            [
                'title' => 'View Permission',
                'description' => 'Can View Permission',
            ]
        );
    }
}
