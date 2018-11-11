# laravel-DingTalk基于laravel5.5的小米推送

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
   
###  3、执行命令

```
    php artisan config:cache 清空配置缓存 
    php artisan vendor:publish 
```
###  5、配置文件
```
    config/mipush.php
```
# 实例

### 实现Text发送
```
$DingTalk = new DingTalk();
$message = new Message();
$data = $message->text('测试text类型');
$res = $DingTalk->send($data);
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
$res = $DingTalk->send($data);
echo $res;
```


#### 暂时实现两种发送，后续会逐个完善，如有需要，欢迎大家提交问题
