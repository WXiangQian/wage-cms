<?php
namespace App\Models;


use App\Events\CreateUserEvent;
use App\Events\DeleteUserEvent;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    // 追加不存在的字段
    protected $appends = ['status'];
    // 事件监听
    protected $dispatchesEvents = [
        'deleted' => DeleteUserEvent::class,
        'created' => CreateUserEvent::class,
    ];

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'd_id');
    }

    public function getStatusAttribute()
    {
        return '已离职';
    }

    /*public function getSexAttribute($sex)
    {
        if ($sex == 1) return '男';
        if ($sex == 2) return '女';
        return '未知';
    }*/

    /*public function getTypeAttribute($type)
    {
        if ($type == 1) return '全职';
        if ($type == 2) return '兼职';
        if ($type == 3) return '实习';
        return '未知';
    }*/
}