<?php

namespace App\Listeners;

use App\Models\Department;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Qian\DingTalk\DingTalk;
use Qian\DingTalk\Message;
use Qiaweicom\Admin\Admin;

class DeleteUserListener
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
        $user = $event->user;
        $departmentId = $user->d_id;
        $department = Department::find($departmentId);
        // 发送到钉钉群
        $DingTalk = new DingTalk();
        $message = new Message();
        // 满足条件为新增员工，否则为修改员工信息
        $content = "🔸{$department->name}-{$user->name}于{$user->deleted_at}离职";
        $send = $message->text($content);
        $DingTalk->send($send);
    }
}
