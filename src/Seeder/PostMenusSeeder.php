<?php

namespace Database\Seeders\Badaso\Post;

use Illuminate\Database\Seeder;

class PostMenusSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @throws Exception
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $menus = [
                0 => [
                    'key' => 'post-module',
                    'display_name' => 'Post Menu',
                    'created_at' => '2021-01-01 15:26:06',
                    'updated_at' => '2021-01-01 15:26:06',
                ],
            ];

            $new_menus = [];
            foreach ($menus as $key => $value) {
                $menu = \DB::table('menus')
                        ->where('key', $value['key'])
                        ->first();

                if (isset($menu)) {
                    continue;
                }
                $new_menus[] = $value;
            }

            \DB::table('menus')->insert($new_menus);
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }

        \DB::commit();
    }
}
