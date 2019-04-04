<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Qian\DingTalk\DingTalk;
use Qian\DingTalk\Message;
use Qiaweicom\Admin\Form;
use Qiaweicom\Admin\Grid;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Controllers\ModelForm;
use Qiaweicom\Admin\Widgets\Table;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ModelForm;

    protected $title = '员工管理';

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
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->name('员工姓名');
            $grid->user_num('员工编号');
            $grid->column('d_id', '部门')->display(function ($d_id) {
                $department = Department::where('id', $d_id)->first();
                return Department::where('id', $department->pid)->first()->name;
            });
            $grid->column('department.name', '岗位');
            $grid->sex('性别')->display(function ($sex) {
                if ($sex == 1) return '男';
                if ($sex == 2) return '女';
                return '未知';
            });
            $grid->type('员工状态')->display(function ($type) {
                if ($type == 1) return '全职';
                if ($type == 2) return '兼职';
                if ($type == 3) return '实习';
                return '未知';
            });
            // 第一种展现方式
            $grid->column('其他信息')->expand(function () {
                // 取具体的字段信息
                $profile = array_only($this->toArray(), ['mobile','email','id_number','back_card_number','basic_wage']);
                // 修改字段的key值
                if ($profile['basic_wage']) {
                    $profile["基本薪资"] = encryptedBasicWage($profile["basic_wage"]);
                    unset ($profile["basic_wage"] );
                }
                if ($profile['id_number']) {
                    $profile["身份证号码"] = encryptedIdNumber($profile["id_number"]);
                    unset ($profile["id_number"] );
                }
                if ($profile['back_card_number']) {
                    $profile["银行卡号"] = encryptedBankCardNumber($profile["back_card_number"]);
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

            $grid->actions(function ($actions) {
                // 当前行的数据数组
                $row = $actions->row;
                // 获取当前行主键值
                $id = $actions->getKey();
                // prepend一个操作
                $actions->prepend("<a href='/admin/users/{$id}/email'><i class='fa fa-paper-plane'></i>发送邮件</a>");
            });

            $grid->filter(function ($query) {

                $query->like('name', '员工姓名');
                $query->like('user_num', '员工编号');
                $query->equal('d_id', '所属岗位')->select(Department::whereNotIn('pid', [0])->pluck('name', 'id'));
                $query->equal('sex', '性别')->select(['1' => '男', '2' => '女']);
                $query->equal('type', '员工状态')->select(['1' => '全职', '2' => '兼职', '3' => '实习']);
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

            $form->display('user_num', '员工编号');
            $form->text('name', '员工姓名');
            // 其中load('d_id', '/admin/users/d_id');的意思是
            // 在当前select的选项切换之后，会把当前选项的值通过参数q, 调用接口/admin/users/d_id，并把api返回的数据填充为d_id选择框的选项
            $form->select('pid', '部门')
                ->options(Department::where('pid', 0)->pluck('name', 'id'))
                ->load('d_id', '/admin/users/d_id')
                ->rules('required');
            $form->select('d_id', '岗位')->options(function ($id) {
                return Department::where('id', $id)->pluck('name', 'id');
            })->rules('required');
            $form->select('sex', '性别')->options([1 => '男', 2 => '女'])->default(1);
            $form->select('type', '员工状态')->options(['1' => '全职', '2' => '兼职', '3' => '实习'])->default(1);
            $form->mobile('mobile', '手机号')->rules('required');
            $form->email('email', '电子邮箱')->rules('required');
            $form->text('id_number', '身份证号码')->rules('required|regex:/^\d{18}$/');
            $form->text('back_card_number', '银行卡号')->rules('required')
                ->help("<span style='color: red'>具体银行公司统一</span>");
            $form->currency('basic_wage', '基本薪资')->rules('required')->symbol('￥');
            $form->ignore(['pid']);
            // 保存后回调
            $form->saved(function (Form $form) {
                // 修改时获取Id
                $userId = request()->route()->parameter('user');
                $departmentId = $form->model()->d_id;
                $department = Department::find($departmentId);
                // 发送到钉钉群
                $DingTalk = new DingTalk();
                $message = new Message();
                $loginUserName = Admin::user()->name;
                // 满足条件为新增员工，否则为修改员工信息
                if (!$userId) {
                    $content = "欢迎新入职同事\n🔸{$department->name}-{$form->model()->name}\n祝工作顺利\n此动态为{$loginUserName}操作";
                } else {
                    $content = "🔸{$department->name}-{$form->model()->name}资料修改成功\n此动态为{$loginUserName}操作";
                }
                // 获取token
                $token = config('dingtalk.talk.token');
                $send = $message->text($content);
                $DingTalk->send($token,$send);
                return ;
            });
        });
    }

    public function d_id(Request $request)
    {
        $q = $request->get('q');

        return Department::where('pid', $q)->get(['id', DB::raw('name as text')]);
    }

    public function email($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('给员工发送email')
            ->body($this->emailForm()->edit($id));
    }

    protected function emailForm()
    {
        return Admin::form(User::class, function (Form $form) {
            $id = request()->route()->parameters()['id'];
            $form->display('name', '员工姓名');
            $form->text('title', '邮箱标题');
            $form->textarea('content', '邮箱内容');
            // 设置表单提交的action
            $form->setAction(admin_base_path("/users/{$id}/send_email"));

        });
    }

    public function sendEmail(Request $request)
    {
        $id = $request->route()->parameters()['id'];
        $title = $request->input('title');
        $content = $request->input('content');
        $user = User::find($id);

        $toMail = $user->email;

        Mail::raw($content, function ($message) use ($toMail, $title) {
            $message->subject($title);
            $message->to($toMail);
        });
        admin_toastr('发送成功', 'success');
        return redirect('/admin/users');
    }


}
