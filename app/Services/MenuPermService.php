<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

class MenuPermService
{
    /**
     * Grouping menus and mapping them with user permissions,
     * to controll user privileges to show menu items collapse in sidebar,
     * if the user has permission on one of the menu item, the collapse will shown
     *
     * Array key is the name of collapse wich groups menu items in collapse,
     * and the array value is the set of parent name of permissions wich is
     * configured in the file <database/seeders/PermissionSeeder.php>.
     *
     * Internal array ['<the action name in model policy wich controlls view action of the model>', <model class>]
     *
     * @var array<string, array<string>>
     */
    protected static $menuGroups = [
        'admin' => [
            'departments' => ['view', App\Models\Department::class],
            'roles' => ['view', Spatie\Permission\Models\Role::class],
            'users' => ['manage', App\Models\User::class],
        ],
    ];

    public static function hasViewPerm(string $menuGroupName): bool
    {
        foreach (self::$menuGroups[$menuGroupName] as $menu) {
            if (Gate::inspect($menu[0], $menu[1])->allowed()) {
                // If the user has permission on one of the menu item, return true.
                return true;
            }
        }

        return false;
    }
}
