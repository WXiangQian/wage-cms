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

Column::extend('prependIcon', function ($value, $icon) {

    return "<span style='color: #999;'><i class='fa fa-$icon'></i>  $value</span>";

});
app('view')->prependNamespace('admin', resource_path('views/admin'));