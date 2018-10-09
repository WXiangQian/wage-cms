<?php
namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Wage extends BaseModel
{
    use SoftDeletes;
    protected $table = 'wages';
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}