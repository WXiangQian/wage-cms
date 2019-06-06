<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExpoter;
use App\Models\Department;
use App\Models\User;
use Qiaweicom\Admin\Form;
use Qiaweicom\Admin\Grid;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Controllers\ModelForm;
use Qiaweicom\Admin\Widgets\Table;

class QuitUsersController extends Controller
{
    use ModelForm;

    protected $title = '离职员工管理';

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
        return Admin::grid(User::class, function (Grid $grid) {
            // 调用删除之后的数据
            $grid->model()->onlyTrashed();
            $grid->model()->orderBy('id', 'desc');

            // 导出
            $excel = new ExcelExpoter();
            $date = date('Y-m-d H:i:s', time());
            $excel->setAttr('离职员工管理'.$date, '离职员工管理',
                ['id','姓名','员工编号','岗位','性别','员工状态','手机号','邮箱','身份证号码'],
                ['id','name','user_num','department.name','sex','type','mobile','email','id_number']);
            $grid->exporter($excel);

            $grid->id('ID')->sortable();
            $grid->name('员工姓名');
            $grid->user_num('员工编号');
            $grid->status('状态');
            $grid->column('department.name', '岗位');
            $grid->sex('性别')->display(function ($sex) {
                if ($sex == 1) return '男';
                if ($sex == 2) return '女';
                return '未知';
            });
            // 第一种展现方式
            $grid->column('其他信息')->expand(function () {
                // 取具体的字段信息
                $profile = array_only($this->toArray(), ['mobile','email','id_number','back_card_number','basic_wage']);
                // 修改字段的key值
                if ($profile['basic_wage']) {
                    $profile["基本薪资"] = $profile["basic_wage"];
                    unset ($profile["basic_wage"] );
                }
                if ($profile['id_number']) {
                    $profile["身份证号码"] = $profile["id_number"];
                    unset ($profile["id_number"] );
                }
                if ($profile['back_card_number']) {
                    $profile["银行卡号"] = $profile["back_card_number"];
                    unset ($profile["back_card_number"] );
                }
                if ($profile['mobile']) {
                    $profile["手机号"] = $profile["mobile"];
                    unset ($profile["mobile"] );
                }
                if ($profile['email']) {
                    $profile["电子邮箱"] = $profile["email"];
                    unset ($profile["email"] );
                }
                return new Table([], $profile);

            }, '点击查看');
            // 注释第二种展现方式
//            $grid->mobile('手机号');
//            $grid->email('电子邮箱')->prependIcon('envelope');
//            $grid->id_number('身份证号码');
//            $grid->back_card_number('银行卡号');
//            $grid->basic_wage('基本薪资');
            $grid->created_at('入职时间')->sortable();
            $grid->deleted_at('离职时间')->sortable();
            // 禁用创建按钮
            $grid->disableCreateButton();
            // 禁用行操作列
            $grid->disableActions();
            // 禁用批量删除
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            // 筛选
            $grid->filter(function ($query) {

                $query->like('name', '员工姓名');
                $query->like('user_num', '员工编号');
                $query->equal('d_id', '所属部门')->select(Department::where('pid', 0)->pluck('name', 'id'));
                $query->equal('sex', '性别')->select(['1' => '男', '2' => '女']);
                $query->like('mobile', '手机号');
                $query->like('email', '电子邮箱');
                $query->like('id_number', '身份证号码');
                $query->like('back_card_number', '银行卡号');
                $query->between('created_at', '入职时间')->datetime();
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
        return Admin::form(User::class, function (Form $form) {

            $form->text('name', '员工姓名');
            $form->select('d_id', '部门')
                ->options(Department::where('pid', 0)->pluck('name', 'id'))
                ->rules('required');
            $form->select('sex', '性别')->options([1 => '男', 2 => '女'])->default('1');
            $form->mobile('mobile', '手机号')->rules('required');
            $form->email('email', '电子邮箱')->rules('required');
            $form->text('id_number', '银行卡号')->rules('required')
                ->help("<span style='color: red'>具体银行公司统一</span>");
            $form->text('back_card_number', '身份证号码')->rules('required|regex:/^\d{18}$/');
            $form->currency('basic_wage', '基本薪资')->rules('required')->symbol('￥');
        });
    }
}
