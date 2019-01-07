<?php

use Illuminate\Database\Seeder;

class AddAdminMenuDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu')->insert([
            'parent_id' => 0,
            'order' => 7,
            'title' => '员工管理',
            'icon' => 'fa-bars',
            'uri' => 'users',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table('admin_menu')->insert([
            'parent_id' => 0,
            'order' => 8,
            'title' => '部门管理',
            'icon' => 'fa-bars',
            'uri' => 'departments',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table('admin_menu')->insert([
            'parent_id' => 0,
            'order' => 9,
            'title' => '工资管理',
            'icon' => 'fa-bars',
            'uri' => 'wages',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table('admin_menu')->insert([
            'parent_id' => 0,
            'order' => 10,
            'title' => '离职员工管理',
            'icon' => 'fa-bars',
            'uri' => 'quit_users',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
