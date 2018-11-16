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
use Vinkla\Hashids\Facades\Hashids;

class HomeController extends Controller
{
    public function index()
    {
        $hashids = Hashids::connection('alternative')->encode(1);
//        $hashids = Hashids::decode('KPCAig');
        dd($hashids);die;
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
                $countDepartment = Department::count();
                $row->column(4, new InfoBox('员工数量', 'users', 'aqua', '/admin/users', "$countUser"));
                $row->column(4, new InfoBox('部门数量', 'book', 'red', '/admin/users', "$countDepartment"));
//                $row->column(4, new InfoBox('New Users', 'shopping-cart', 'aqua', '/demo/users', '1024'));

            });
        });
    }
}
