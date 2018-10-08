<?php
namespace App\Models;


class User extends BaseModel
{
    protected $table = 'users';

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'd_id');
    }
}