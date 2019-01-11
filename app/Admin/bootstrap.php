<?php

use Qiaweicom\Admin\Grid\Column;
/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Qiaweicom\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Qiaweicom\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Qiaweicom\Admin\Form::forget(['map', 'editor']);

Column::extend('expand', \App\Admin\Extensions\Column\ExpandRow::class);
Column::extend('prependIcon', function ($value, $icon) {

    return "<span style='color: #999;'><i class='fa fa-$icon'></i>  $value</span>";

});
app('view')->prependNamespace('admin', resource_path('views/admin'));

use Qiaweicom\Admin\Facades\Admin;

Admin::navbar(function (\Qiaweicom\Admin\Widgets\Navbar $navbar) {

    $navbar->left(view('admin.search-bar'));

});