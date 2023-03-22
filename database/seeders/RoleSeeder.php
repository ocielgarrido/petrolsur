<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role1=  Role::create(['name'=>'Admin']);
      $role2=  Role::create(['name'=>'Supervisor']);
      $role3=  Role::create(['name'=>'Usuario']);
      $role4=  Role::create(['name'=>'Gerencia']);
      Permission::create(['name'=>'user.index'])->syncRoles([$role1,$role2,$role4]);
    }
}
