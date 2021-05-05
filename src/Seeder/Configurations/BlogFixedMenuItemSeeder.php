<?php

use Illuminate\Database\Seeder;

class BlogFixedMenuItemSeeder extends Seeder
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
            $menu_id = \DB::table('menus')->where('key', 'badaso-blog-module')->first()->id;

            $menu_items = [
                0 => [
                    'menu_id'     => $menu_id,
                    'title'       => 'Posts',
                    'url'         => '/post',
                    'target'      => '_self',
                    'icon_class'  => 'post_add',
                    'color'       => '',
                    'parent_id'   => null,
                    'order'       => 1,
                    'permissions' => 'browse_posts',
                    'created_at'  => '2021-01-01 15:26:06',
                    'updated_at'  => '2021-01-01 15:26:06',
                ],
                1 => [
                    'menu_id'     => $menu_id,
                    'title'       => 'Categories',
                    'url'         => '/category',
                    'target'      => '_self',
                    'icon_class'  => 'category',
                    'color'       => '',
                    'parent_id'   => null,
                    'order'       => 2,
                    'permissions' => 'browse_categories',
                    'created_at'  => '2021-01-01 15:26:06',
                    'updated_at'  => '2021-01-01 15:26:06',
                ],
                2 => [
                    'menu_id'     => $menu_id,
                    'title'       => 'Tags',
                    'url'         => '/tag',
                    'target'      => '_self',
                    'icon_class'  => 'local_offer',
                    'color'       => '',
                    'parent_id'   => null,
                    'order'       => 3,
                    'permissions' => 'browse_tags',
                    'created_at'  => '2021-01-01 15:26:06',
                    'updated_at'  => '2021-01-01 15:26:06',
                ],
                3 => [
                    'menu_id'     => $menu_id,
                    'title'       => 'Comments',
                    'url'         => '/comment',
                    'target'      => '_self',
                    'icon_class'  => 'chat',
                    'color'       => '',
                    'parent_id'   => null,
                    'order'       => 3,
                    'permissions' => 'browse_comments',
                    'created_at'  => '2021-01-01 15:26:06',
                    'updated_at'  => '2021-01-01 15:26:06',
                ],
            ];

            $new_menu_items = [];
            foreach ($menu_items as $key => $value) {
                $menu_item = \DB::table('menu_items')
                        ->where('menu_id', $value['menu_id'])
                        ->where('url', $value['url'])
                        ->first();

                if (isset($menu_item)) {
                    continue;
                }
                $new_menu_items[] = $value;
            }

            \DB::table('menu_items')->insert($new_menu_items);
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }

        \DB::commit();
    }
}
