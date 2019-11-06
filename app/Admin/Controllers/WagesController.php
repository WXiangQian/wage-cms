<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExpoter;
use App\Models\User;
use App\Models\Wage;
use Qiaweicom\Admin\Form;
use Qiaweicom\Admin\Grid;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Controllers\ModelForm;

class WagesController extends Controller
{
    use ModelForm;

    protected $title = '工资管理';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('修改')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Wage::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');

            // 导出
            $excel = new ExcelExpoter();
            $date = date('Y-m-d H:i:s', time());
            $excel->setAttr($this->title.$date, $this->title,
                ['id','员工','基本薪资','绩效提成','补贴','奖金','加班费','年终奖','五险一金','个税','扣款','实际工资','发放时间'],
                ['id','user.name','user.basic_wage','achievements','allowance','bonus','overtime_pay','annua_bonus','five_one_insurance','personal_tax','withdrawing','actual_wage','created_at']);
            $grid->exporter($excel);

            $grid->id('ID')->sortable();
            $grid->column('user.name', '员工');
            $grid->column('user.basic_wage', '基本薪资')->sortable();
            $grid->achievements('绩效提成');
            $grid->allowance('补贴');
            $grid->bonus('奖金');
            $grid->overtime_pay('加班费');
            $grid->annua_bonus('年终奖');
            $grid->five_one_insurance('五险一金');
            $grid->personal_tax('个税');
            $grid->withdrawing('扣款');
            $grid->actual_wage('实际工资')->sortable();
            $grid->created_at('发放时间')->sortable();

            $grid->filter(function ($query) {

                $query->like('user.name', '员工姓名');
                $query->between('created_at', '发放时间')->datetime();
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Wage::class, function (Form $form) {

            $form->tab('基本信息', function ($form) {

                $form->select('user_id', '员工')
                    ->options(User::pluck('name', 'id'))
                    ->rules('required');
                $form->number('working_day', '当月工作日')->rules('required|numeric');
                $form->number('days_of_attendance', '出勤天数')->rules('required|numeric');
                $form->currency('achievements', '绩效提成')->default(0)->symbol('￥');
                $form->currency('allowance', '补贴')->default(0)->symbol('￥');
                $form->currency('bonus', '奖金')->default(0)->symbol('￥');
                $form->currency('overtime_pay', '加班费')->default(0)->symbol('￥');
                $form->currency('annua_bonus', '年终奖')->default(0)->symbol('￥');
                $form->currency('personal_tax', '个税')->default(0)->symbol('￥');
                $form->currency('withdrawing', '扣款')->default(0)->symbol('￥');

            })->tab('五险一金', function ($form) {

                $form->currency('endowment_insurance', '养老保险')->default(0)->symbol('￥');
                $form->currency('unemployment_insurance', '失业保险')->default(0)->symbol('￥');
                $form->currency('medical_insurance', '医疗保险')->default(0)->symbol('￥');
                $form->currency('employment_injury_insurance', '工伤保险')->default(0)->symbol('￥');
                $form->currency('maternity_insurance', '生育保险')->default(0)->symbol('￥');
                $form->currency('housing_fund', '住房公积金')->default(0)->symbol('￥');

            });

            $form->saving(function (Form $form) {
                // 查询出员工的基本薪资
                $userId = $form->user_id;
                $user = User::find($userId);
                $basic_wage = $user->basic_wage;
                // 工作日
                $working_day = $form->working_day;
                $days_of_attendance = $form->days_of_attendance;
                // 基本信息
                $achievements = $form->achievements;
                $allowance = $form->allowance;
                $bonus = $form->bonus;
                $overtime_pay = $form->overtime_pay;
                $annua_bonus = $form->annua_bonus;
                $personal_tax = $form->personal_tax;
                $withdrawing = $form->model()->withdrawing;
                // 五险一金
                $five_one_insurance = $form->five_one_insurance = $form->model()->five_one_insurance = 0;;
                $endowment_insurance = $form->endowment_insurance;
                $unemployment_insurance = $form->unemployment_insurance;
                $medical_insurance = $form->medical_insurance;
                $employment_injury_insurance = $form->employment_injury_insurance;
                $maternity_insurance = $form->maternity_insurance;
                $housing_fund = $form->housing_fund;
                // 若有一个存在，则进行运算
                if ($endowment_insurance || $unemployment_insurance || $medical_insurance || $employment_injury_insurance || $maternity_insurance || $housing_fund) {
                    $five_one_insurance = $form->model()->five_one_insurance = $endowment_insurance + $unemployment_insurance + $medical_insurance + $employment_injury_insurance + $maternity_insurance + $housing_fund;
                }
                // 实际发放
                $form->model()->actual_wage = $basic_wage / $working_day * $days_of_attendance + $achievements + $allowance + $bonus + $overtime_pay + $annua_bonus - $withdrawing - $five_one_insurance - $personal_tax;

            });
        });
    }
}
