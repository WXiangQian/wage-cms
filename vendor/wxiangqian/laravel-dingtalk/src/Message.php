<?php

namespace  Qian\DingTalk;

class Message
{
    // 此消息类型为固定
    protected $msgType;
    // 	被@人的手机号(在text内容里要有@手机号)
    protected $atMobiles = [];
    // @所有人时:true,否则为:false
    protected $isAtAll = false;
    public $content;
    protected $text;
    protected $link;
    // 单条信息后面图片的URL
    protected $picUrl;
    // 点击单条信息到跳转链接
    protected $messageUrl;

    public function text(string $content)
    {
        $this->msgType = 'text';
        $this->content = $content;
        return $this;
    }
    public function link(string $title, string $text, string $messageUrl, string $picUrl='')
    {
        $this->msgType = 'link';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        $data['picUrl'] = $picUrl;
        $data['messageUrl'] = $messageUrl;
        $this->content = $data;
        return $this;
    }
    public function markdown(string $title, string $text)
    {
        $this->msgType = 'markdown';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        $this->content = $data;
        return $this;
    }
    public function actionCard(string $title, string $text, string $singleTitle, string $singleURL, string $btnOrientation = '0', string $hideAvatar = '0')
    {
        $this->msgType = 'actionCard';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        // 单个按钮的方案。(设置此项和singleURL后btns无效。)
        $data['singleTitle'] = $singleTitle;
        // 点击singleTitle按钮触发的URL
        $data['singleURL'] = $singleURL;
        // 	0-按钮竖直排列，1-按钮横向排列
        $data['btnOrientation'] = $btnOrientation;
        // 0-正常发消息者头像,1-隐藏发消息者头像
        $data['hideAvatar'] = $hideAvatar;
        $this->content = $data;
        return $this;
    }
    public function feedCard(array $cards)
    {
        $this->msgType = 'feedCard';
//    	TODO: add validation
        $data['links'] = $cards;
        $this->content = $data;
        return $this;
    }
    public function at(array $mobiles, bool $isAtAll)
    {
        $this->atMobiles = $mobiles;
        $this->isAtAll = $isAtAll;
        return $this;
    }
    public function getMsgType()
    {
        return $this->msgType;
    }
    public function getAtMobiles()
    {
        return $this->atMobiles;
    }
    public function getIsAtAll()
    {
        return $this->isAtAll;
    }
}