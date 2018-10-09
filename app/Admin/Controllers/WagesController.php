<?php

namespace App\Admin\Controllers;

use App\Models\Department;
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
            $grid->id('ID')->sortable();
            $grid->column('user.name', '员工');
            $grid->column('user.basic_wage', '基本薪资');
            $grid->achievements('绩效提成');
            $grid->allowance('补贴');
            $grid->bonus('奖金');
            $grid->overtime_pay('加班费');
            $grid->annua_bonus('年终奖');
            $grid->five_one_insurance('五险一金');
            $grid->personal_tax('个税');
            $grid->actual_wage('实际工资');
            $grid->created_at('发放时间');

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

            $form->text('name', '员工姓名');
            $form->select('d_id', '部门')
                ->options(Department::where('pid', 0)->pluck('name', 'id'))
                ->rules('required');
            $form->select('sex', '性别')->options([1 => '男', 2 => '女']);
            $form->mobile('mobile', '手机号')->rules('required');
            $form->email('email', '电子邮箱')->rules('required');
            $form->text('id_number', '银行卡号')->rules('required');
            $form->text('back_card_number', '身份证号码')->rules('required|regex:/^\d{18}$/');
        });
    }
}
