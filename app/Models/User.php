<?php
namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    // 追加不存在的字段
    protected $appends = ['status'];

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'd_id');
    }

    public function getStatusAttribute()
    {
        return '已离职';
    }
}