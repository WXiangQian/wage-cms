<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Qiaweicom\Admin\Layout\Content;
use Illuminate\Http\Request;
use Qiaweicom\Admin\Controllers\ModelForm;

class ExpressController extends Controller
{
    use ModelForm;

    protected $title = '快递';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->title . '管理')
            ->description($this->title . '查询')
            ->body(view('admin.kuaidi'));
    }


}
