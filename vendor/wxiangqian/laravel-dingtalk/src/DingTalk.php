<?php
namespace Qian\DingTalk;


class DingTalk
{

    public function tokenIsRequired()
    {
        return 'Token is not found';
    }
    public function responseError($code, $message)
    {
        return 'Status Code: ' . $code . 'Error Message: ' . $message;
    }


    public function send($res)
    {
        if (empty(config('dingtalk.talk.token')))
        {
            return $this->tokenIsRequired();
        }
        $url = 'https://oapi.dingtalk.com/robot/send?access_token=' . config('dingtalk.talk.token');
        $body = $this->buildRequestPayload($res);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resp = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($resp);

        if ($data->errcode != 0)
        {
            return $this->responseError($data->errcode, $data->errmsg);
        }

        return 'Success';
    }

    public function buildRequestPayload(Message $message)
    {
        $data = [];
        switch ($message->getMsgType())
        {
            case 'text':
                $data['msgtype'] = 'text';
                $data['text']['content'] = $message->content;
                break;
            case 'link':
                $data['msgtype'] = 'link';
                $data['link'] = $message->content;
                break;
            case 'markdown':
                $data['msgtype'] = 'markdown';
                $data['markdown'] = $message->content;
                break;
            case 'actionCard':
                $data['msgtype'] = 'actionCard';
                $data['actionCard'] = $message->content;
                break;
            case 'feedCard':
                $data['msgtype']  = 'feedCard';
                $data['feedCard'] = $message->content;
                break;
        }
        return json_encode($data);
    }
}