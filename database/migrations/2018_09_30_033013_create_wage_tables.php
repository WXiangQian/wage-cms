<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // departments部门表
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('部门名称');
            $table->unsignedInteger('pid')->default(0)->comment('上级id');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        // users用户表
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('员工姓名');
            $table->string('d_id', 100)->comment('部门id');
            $table->decimal('basic_wage')->comment('基本薪资');
            $table->unsignedInteger('sex')->default(0)->comment('性别0未知1男2女');
            $table->string('mobile', 100)->comment('手机号');
            $table->string('email', 100)->comment('电子邮箱');
            $table->string('id_number', 100)->comment('身份证号码');
            $table->string('back_card_number', 100)->comment('银行卡号');
            $table->softDeletes();
            $table->timestamps();
        });

        // wages工资表
        Schema::create('wages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('working_day', 100)->comment('当月工作日');
            $table->string('days_of_attendance', 100)->comment('出勤天数');
            $table->decimal('achievements')->comment('绩效提成');
            $table->decimal('allowance')->comment('补贴');
            $table->decimal('bonus')->comment('奖金');
            $table->decimal('overtime_pay')->comment('加班费');
            $table->decimal('annua_bonus')->comment('年终奖');
            $table->decimal('endowment_insurance')->comment('养老保险');
            $table->decimal('unemployment_insurance')->comment('失业保险');
            $table->decimal('medical_insurance')->comment('医疗保险');
            $table->decimal('employment_injury_insurance')->comment('工伤保险');
            $table->decimal('maternity_insurance')->comment('生育保险');
            $table->decimal('housing_fund')->comment('住房公积金');
            $table->decimal('five_one_insurance')->comment('五险一金');
            $table->decimal('personal_tax')->comment('个税');
            $table->decimal('withdrawing')->comment('扣款');
            $table->decimal('actual_wage')->comment('实际工资');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('users');
        Schema::dropIfExists('wages');
    }
}
