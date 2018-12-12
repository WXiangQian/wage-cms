<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Qiaweicom\Admin\Controllers\Dashboard;
use Qiaweicom\Admin\Facades\Admin;
use Qiaweicom\Admin\Layout\Column;
use Qiaweicom\Admin\Layout\Content;
use Qiaweicom\Admin\Layout\Row;
use Qiaweicom\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $countUser = User::count();
                $countUserByType1 = User::where('type', 1)->count();
                $countUserByType2 = User::where('type', 2)->count();
                $countUserByType3 = User::where('type', 3)->count();
//                $countDepartment = Department::count();
                $row->column(4, new InfoBox('在职员工数量', 'users', 'aqua', '/admin/users', $countUser));
                $row->column(4, new InfoBox('全职员工数量', 'users', 'aqua', '/admin/users?type=1', $countUserByType1));
                $row->column(4, new InfoBox('兼职员工数量', 'users', 'aqua', '/admin/users?type=2', $countUserByType2));
                $row->column(4, new InfoBox('实习员工数量', 'users', 'aqua', '/admin/users?type=3', $countUserByType3));
//                $row->column(4, new InfoBox('部门数量', 'book', 'red', '/admin/users', $countDepartment));
//                $row->column(4, new InfoBox('New Users', 'shopping-cart', 'aqua', '/demo/users', '1024'));

            });
        });
    }
}
