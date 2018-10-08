<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\User;
use Qiaweicom\Admin\Form;
use Qiaweicom\Admin\Grid;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Controllers\ModelForm;

class UsersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('员工管理');
            $content->description('');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('员工管理');
            $content->description('修改员工信息');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('员工管理');
            $content->description('新增员工');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->name('员工姓名');
            $grid->column('department.name', '部门');
            $grid->sex('性别')->display(function ($sex) {
                if ($sex == 1) return '男';
                if ($sex == 2) return '女';
                return '未知';
            });
            $grid->mobile('手机号');
            $grid->email('电子邮箱');
            $grid->id_number('身份证号码');
            $grid->back_card_number('银行卡号');
            $grid->basic_wage('基本薪资');
            $grid->created_at('入职时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->text('name', '员工姓名');
            $form->select('department.name', '部门')
                ->options(Department::where('pid', 0)->pluck('name', 'id')->toArray())
                ->rules('required');
            $form->select('sex', '性别')->options([1 => '男', 2 => '女']);
            $form->text('mobile', '手机号')->rules('required|regex:/^1[0-9]{10}$/');
            $form->text('email', '电子邮箱')->rules('required|regex:/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/');
            $form->text('id_number', '银行卡号')->rules('required');
            $form->text('back_card_number', '身份证号码')->rules('required|regex:/^\d{18}$/');
            $form->number('basic_wage', '基本薪资')->rules('required');
        });
    }
}
