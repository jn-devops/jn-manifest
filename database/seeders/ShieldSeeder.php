<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_trip::ticket","view_any_trip::ticket","create_trip::ticket","update_trip::ticket","view_account","view_any_account","create_account","update_account","restore_account","restore_any_account","replicate_account","reorder_account","delete_account","delete_any_account","force_delete_account","force_delete_any_account","view_approver","view_any_approver","create_approver","update_approver","restore_approver","restore_any_approver","replicate_approver","reorder_approver","delete_approver","delete_any_approver","force_delete_approver","force_delete_any_approver","view_car::type","view_any_car::type","create_car::type","update_car::type","restore_car::type","restore_any_car::type","replicate_car::type","reorder_car::type","delete_car::type","delete_any_car::type","force_delete_car::type","force_delete_any_car::type","view_company","view_any_company","create_company","update_company","restore_company","restore_any_company","replicate_company","reorder_company","delete_company","delete_any_company","force_delete_company","force_delete_any_company","view_department","view_any_department","create_department","update_department","restore_department","restore_any_department","replicate_department","reorder_department","delete_department","delete_any_department","force_delete_department","force_delete_any_department","view_employee","view_any_employee","create_employee","update_employee","restore_employee","restore_any_employee","replicate_employee","reorder_employee","delete_employee","delete_any_employee","force_delete_employee","force_delete_any_employee","view_employee::group","view_any_employee::group","create_employee::group","update_employee::group","restore_employee::group","restore_any_employee::group","replicate_employee::group","reorder_employee::group","delete_employee::group","delete_any_employee::group","force_delete_employee::group","force_delete_any_employee::group","view_location::reason","view_any_location::reason","create_location::reason","update_location::reason","restore_location::reason","restore_any_location::reason","replicate_location::reason","reorder_location::reason","delete_location::reason","delete_any_location::reason","force_delete_location::reason","force_delete_any_location::reason","view_market::segment","view_any_market::segment","create_market::segment","update_market::segment","restore_market::segment","restore_any_market::segment","replicate_market::segment","reorder_market::segment","delete_market::segment","delete_any_market::segment","force_delete_market::segment","force_delete_any_market::segment","view_project","view_any_project","create_project","update_project","restore_project","restore_any_project","replicate_project","reorder_project","delete_project","delete_any_project","force_delete_project","force_delete_any_project","view_provider","view_any_provider","create_provider","update_provider","restore_provider","restore_any_provider","replicate_provider","reorder_provider","delete_provider","delete_any_provider","force_delete_provider","force_delete_any_provider","restore_trip::ticket","restore_any_trip::ticket","replicate_trip::ticket","reorder_trip::ticket","delete_trip::ticket","delete_any_trip::ticket","force_delete_trip::ticket","force_delete_any_trip::ticket","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]},{"name":"panel_user","guard_name":"web","permissions":[]},{"name":"Sales","guard_name":"web","permissions":["view_trip::ticket","view_any_trip::ticket","create_trip::ticket","update_trip::ticket"]},{"name":"Marketing","guard_name":"web","permissions":["view_trip::ticket","view_any_trip::ticket","update_trip::ticket"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
