<?php

namespace Database\Seeders\Badaso\Blog;

use Illuminate\Database\Seeder;

class BadasoModuleBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BlogMenusSeeder::class);
        $this->call(BlogFixedMenuItemSeeder::class);
        $this->call(BlogRolesSeeder::class);
        $this->call(BlogPermissionsSeeder::class);
        $this->call(BlogRolePermissionsSeeder::class);
    }
}
