<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $modelFiles = File::files(app_path('Models'));

        $ignoreModels = [
            'File',
            'ClientAccountTransaction',
            'SafeTransaction',
            'WarehouseTransaction',
            'ShippingAddress'
        ];

        $actions = [
            'view'   => 'View',
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete'
        ];

        $allPermissions = [];

        foreach ($modelFiles as $file) {
            $model = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            if (in_array($model, $ignoreModels)) {
                continue;
            }
            $modelKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));
            $groupName = str_replace('_', ' ', ucfirst($modelKey));

            foreach ($actions as $actionKey => $actionLabel) {
                $permissionName = "{$actionKey}_{$modelKey}";
                $displayName = "{$actionLabel} " . str_replace('_', ' ', $modelKey);

                $permission = Permission::updateOrCreate(
                    ['name' => $permissionName],
                    [
                        'display_name' => ucwords($displayName),
                        'group_name'   => ucwords($groupName),
                    ]
                );
                $allPermissions[] = $permission->name;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Role CRUD Permissions
        |--------------------------------------------------------------------------
        */
        $rolePermissions = [
            'view_role'   => 'View Role',
            'create_role' => 'Create Role',
            'update_role' => 'Update Role',
            'delete_role' => 'Delete Role',
        ];

        foreach ($rolePermissions as $perm => $label) {
            Permission::updateOrCreate(
                ['name' => $perm],
                [
                    'display_name' => $label,
                    'group_name'   => 'Role',
                ]
            );
            $allPermissions[] = $perm;
        }
        /*
        |--------------------------------------------------------------------------
        | Settings Permissions
        |--------------------------------------------------------------------------
        */
        Permission::updateOrCreate(
            ['name' => 'view_settings'],
            [
                'display_name' => 'View Settings',
                'group_name'   => 'Settings',
            ]
        );
        $allPermissions[] = 'view_settings';

        Permission::updateOrCreate(
            ['name' => 'view_inventory'],
            [
                'display_name' => 'View Inventory',
                'group_name'   => 'Inventory',
            ]
        );
        $allPermissions[] = 'view_inventory';

        Permission::updateOrCreate(
            ['name' => 'update_balance'],
            [
                'display_name' => 'Update Balance',
                'group_name'   => 'Balance',
            ]
        );
        $allPermissions[] = 'update_balance';
        Permission::updateOrCreate(
            ['name' => 'low_stock'],
            [
                'display_name' => 'Low Stock',
                'group_name'   => 'Stock',
            ]
        );
        $allPermissions[] = 'low_stock';

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */
        $roles = [
            'admin' => $allPermissions,

            'manager' => array_filter($allPermissions, fn ($p) =>
                str_contains($p, 'view') || str_contains($p, 'update')),

            'cashier' => array_filter($allPermissions, fn ($p) =>
                str_contains($p, 'view') || str_contains($p, 'create')),
        ];
        foreach ($roles as $roleName => $permissions) {
            Role::updateOrCreate(['name' => $roleName])
                ->syncPermissions($permissions);
        }
    }
}
