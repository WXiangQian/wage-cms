<?php

use Illuminate\Database\Seeder;

class CreateWagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x=0; $x<=10; $x++) {
            DB::table('wages')->insert([
                'user_id' => rand(1,10),
                'working_day' => rand(20,25),
                'days_of_attendance' => 20,
                'achievements' => rand(111,999),
                'allowance' => rand(111,999),
                'bonus' => rand(111,999),
                'overtime_pay' => rand(111,999),
                'annua_bonus' => rand(111,999),
                'endowment_insurance' => rand(11,99),
                'unemployment_insurance' => rand(11,99),
                'medical_insurance' => rand(11,99),
                'employment_injury_insurance' => rand(11,99),
                'maternity_insurance' => rand(11,99),
                'housing_fund' => 273,
                'five_one_insurance' => rand(111,999),
                'personal_tax' => rand(111,999),
                'withdrawing' => rand(11,99),
                'actual_wage' => rand(3000,19999),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }
    }
}
