<?php

namespace Database\Seeders\Badaso\Post;

use Illuminate\Database\Seeder;

class BadasoPostModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostMenusSeeder::class);
        $this->call(PostFixedMenuItemSeeder::class);
        $this->call(PostRolesSeeder::class);
        $this->call(PostPermissionsSeeder::class);
        $this->call(PostRolePermissionsSeeder::class);
    }
}
