<?php

namespace Database\Seeders\Badaso\Post;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Menu;

class PostMenusSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $menus = [
                0 => [
                    'key' => 'post-module',
                    'display_name' => 'Post Menu',
                ],
            ];

            $new_menus = [];
            foreach ($menus as $key => $value) {
                $menu = Menu::where('key', $value['key'])->first();

                if (isset($menu)) {
                    continue;
                }
                Menu::create($value);
            }
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }

        \DB::commit();
    }
}
