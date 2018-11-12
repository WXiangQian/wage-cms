<?php
namespace App\Models;


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
    ];

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'd_id');
    }

    public function getStatusAttribute()
    {
        return '已离职';
    }
}