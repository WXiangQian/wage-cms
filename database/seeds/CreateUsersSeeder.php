<?php

use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($x=0; $x<=10; $x++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'd_id' => rand(1,7),
                'basic_wage' => rand(3000,19999),
                'sex' => rand(1,2),
                'mobile' => "178".rand(11111111,99999999),
                'email' => rand(111111,999999)."@qq.com",
                'id_number' => "1301281997".rand(11111111,99999999),
                'back_card_number' => "62284806389275".rand(11111,99999),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }
    }
}
