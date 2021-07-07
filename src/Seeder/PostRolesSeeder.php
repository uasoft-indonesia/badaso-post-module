<?php

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Role;

class PostRolesSeeder extends Seeder
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
            $roles = [
                'name'         => 'editor',
                'display_name' => 'Editor',
                'created_at'   => '2021-01-01 15:26:06',
                'updated_at'   => '2021-01-01 15:26:06',
            ];

            Role::firstOrCreate($roles);

            \DB::commit();
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }
    }
}
