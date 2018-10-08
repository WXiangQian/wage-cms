<?php
namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'd_id');
    }
}