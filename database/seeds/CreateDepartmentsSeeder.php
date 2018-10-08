<?php

use Illuminate\Database\Seeder;

class CreateDepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            '0' => '人事部',
            '1' => '行政部',
            '2' => '财务部',
            '3' => '客服部',
            '4' => '营销部',
            '5' => '技术部',
            '6' => '销售部',
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name' => $department,
                'pid' => 0,
                'sort' => 0,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

    }
}
