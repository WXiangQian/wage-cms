# laravel-DingTalk是基于laravel5.5开发的钉钉机器人
```
当前自定义机器人支持
文本（text）、链接（link）、markdown（markdown）三种消息类型
大家可以根据自己的使用场景选择合适的消息类型，达到最好的展示样式
```

# 安装方法
### 1、安装
```
    composer require WXiangQian/laravel-DingTalk    
    composer install
```   
或
```  
    composer.json 中添加 "WXiangQian/laravel-DingTalk": "^1.0"  
    composer update 
```
1.0为版本号，可替换
如果无法安装 请执行一下 composer update nothing 然后 composer update
 
 
###  2、配置app.php

在config/app.php 'providers' 中添加 
```
\Qian\DingTalk\DingTalkServiceProvider::class
```
   
###  3、执行命令生成配置文件

```
   php artisan vendor:publish 
```
```
   则生成 config/dingtalk.php
```
# 实例

```
$token可以去调用dingtalk.php里面的talk中的token
因为有时候一个项目会需要配置多个群的通知
所以决定修改的更灵活一点
```
### 实现Text发送
```
$DingTalk = new DingTalk();
$message = new Message();
$data = $message->text('测试text类型');
$res = $DingTalk->send($token,$data);
echo $res;
```
### 实现Link发送
```
$DingTalk = new DingTalk();
$message = new Message();
$title = '测试link类型title';
$text = '测试link类型text';
$messageUrl = 'https://www.baidu.com/';
$picUrl = '';
$data = $message->link($title, $text, $messageUrl, $picUrl);
$res = $DingTalk->send($token,$data);
echo $res;
```
### 实现Markdown发送
```
$DingTalk = new DingTalk();
$message = new Message();
$title = '北京天气MD';
$text = '# laravel-DingTalk是基于laravel5.5开发的钉钉机器人';
$data = $message->markdown($title, $text);
$res = $DingTalk->send($token,$data);
echo $res;
```
####  如满足您的需求，请留下来点个赞吧
