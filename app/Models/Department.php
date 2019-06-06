<?php
namespace App\Models;


use Qiaweicom\Admin\Traits\AdminBuilder;
use Qiaweicom\Admin\Traits\ModelTree;

class Department extends BaseModel
{
    use ModelTree, AdminBuilder;
    protected $table = 'departments';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');
    }
}