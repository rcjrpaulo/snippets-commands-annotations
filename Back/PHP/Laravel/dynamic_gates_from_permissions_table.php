<?php

// file: app/Providers/AuthServiceProvider.php method: boot
// with this you can use $this-authorize in controllers or @can in blade.

public function boot()
{
    $this->registerPolicies();

    if (Schema::hasTable('permissions')) {
        $permissions = app(PermissionRepository::class)->all();

        //faz um foreach das permissoes existentes para definir o gate de cada permissao
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) use($permission) {
                if ($user->is_admin) {
                    //tem todas as permissões se for admin
                    return true;
                }

                if (empty($user->roles) && !count($user->roles->pluck('permissions')->flatten()) && empty($user->permissions)) {
                    return false;
                }

                //pega o array de permissoes (permissões das roles e permissões atreladas diretamente no usuário)
                $arrayUserRolePermissions = $user->roles->pluck('permissions')->flatten()->pluck('name')->toArray();
                $arrayUserPermissions = $user->permissions->pluck('name')->toArray();
                $arrayAllUserPermissions = array_merge($arrayUserRolePermissions, $arrayUserPermissions);

                //se o usuario tem a permissao, retorna true, se não, false
                return in_array($permission->name, $arrayAllUserPermissions);
            });
        }

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}