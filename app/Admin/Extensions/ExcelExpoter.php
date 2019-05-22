<?php
namespace App\Admin\Extensions;

use Maatwebsite\Excel\Facades\Excel;
use Qiaweicom\Admin\Grid\Exporters\AbstractExporter;

class ExcelExpoter extends AbstractExporter
{
    protected $file_name = 'file';
    protected $sheet_name = 'sheet';
    protected $head = [];
    protected $body = [];

    public function setAttr($file_name, $sheet_name, $head, $body)
    {
        $this->file_name = $file_name;
        $this->sheet_name = $sheet_name;
        $this->head = $head;
        $this->body = $body;
    }

    public function export()
    {
        Excel::create($this->file_name, function($excel) {
            $excel->sheet($this->sheet_name, function($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $body = $this->body;

                $bodyRows = collect($this->getData())->map(function ($item) use($body) {
                    $arr = [];

                    foreach($body as $value) {
                        if ($value == 'sex') {
                            if ($item['sex'] == 1)  $item['sex'] = '男';
                            if ($item['sex'] == 2)  $item['sex'] = '女';
                            $arr[] = array_get($item, $value);
                        } else {
                            $arr[] = array_get($item, $value);
                        }
                    }

                    return $arr;
                });
                $rows = collect([$this->head])->merge($bodyRows);
                $sheet->rows($rows);
            });
        })->export('xls');//.xls .csv ...
    }
}