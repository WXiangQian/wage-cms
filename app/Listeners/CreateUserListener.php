<?php

namespace App\Listeners;


use App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class CreateUserListener
{
    public $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // 获取user对象
        $user = $event->user;
        // 获取用户id
        $userId = $user->id;
        // 生成员工编号
        $user->user_num = Hashids::encode($userId);
        $user->save();
    }
}
