<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use Qiaweicom\Admin\Form;
use Qiaweicom\Admin\Grid;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Controllers\ModelForm;
use Qiaweicom\Admin\Tree;

class DepartmentsController extends Controller
{
    use ModelForm;

    protected $title = '部门管理';

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
            ->body($this->tree());
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
            ->description('修改部门信息')
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
            ->description('新增部门')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function tree()
    {
        return Department::tree(function (Tree $tree) {

            $tree->branch(function ($data) {
                return "{$data['name']}";

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
        return Admin::form(Department::class, function (Form $form) {

            $form->text('name', '部门名称');
            $form->select('pid', '上级id')->options(Department::selectOptions());
        });
    }
}
