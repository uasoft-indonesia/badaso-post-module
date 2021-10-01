<?php

namespace Database\Seeders\Badaso\Post;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Menu;
use Uasoft\Badaso\Models\MenuItem;

class PostFixedMenuItemSeeder extends Seeder
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
            $menu_id = Menu::where('key', 'post-module')->firstOrFail()->id;
            $menu_items = [
                0 => [
                    'menu_id' => $menu_id,
                    'title' => 'Posts',
                    'url' => '/post',
                    'target' => '_self',
                    'icon_class' => 'post_add',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 1,
                    'permissions' => 'browse_posts',
                ],
                1 => [
                    'menu_id' => $menu_id,
                    'title' => 'Categories',
                    'url' => '/category',
                    'target' => '_self',
                    'icon_class' => 'category',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 2,
                    'permissions' => 'browse_categories',
                ],
                2 => [
                    'menu_id' => $menu_id,
                    'title' => 'Tags',
                    'url' => '/tag',
                    'target' => '_self',
                    'icon_class' => 'local_offer',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 3,
                    'permissions' => 'browse_tags',
                ],
                3 => [
                    'menu_id' => $menu_id,
                    'title' => 'Comments',
                    'url' => '/comment',
                    'target' => '_self',
                    'icon_class' => 'chat',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 3,
                    'permissions' => 'browse_comments',
                ],
            ];

            $new_menu_items = [];
            foreach ($menu_items as $key => $value) {
                $menu_item = MenuItem::where('menu_id', $value['menu_id'])
                        ->where('url', $value['url'])
                        ->first();

                if (isset($menu_item)) {
                    continue;
                }

                MenuItem::create($value);
            }
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }

        \DB::commit();
    }
}
