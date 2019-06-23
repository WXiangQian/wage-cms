# wage-cms  
基于laravel-admin开发的工资管理系统，针对于中小型企业。项目内有查询快递功能，方便用户查询具体快递信息,新增导出excel功能方便对员工数据进行管理

```
本项目可以直接用，也可以用于二次开发，二次开发具体看相关文档
laravel版本为5.5.*、laravel-admin版本为1.5.*
```
[laravel-admin文档地址](https://laravel-admin.org/docs/zh)
### 克隆仓库
```
git clone git@github.com:WXiangQian/wage-cms.git
```

### 运行环境
```
"php": ">=7.0.0"
```

### 生成配置文件
```
cp .env.example .env
```
你可以根据情况修改 .env 文件里的内容，如数据库连接、缓存、邮件设置等。

### 生成秘钥
```
php artisan key:generate
```

### 配置好.env以后执行以下命令进行创建数据库
(提示directory already exists 可忽略)

```
php artisan admin:install
```

### 如需测试数据，则执行以下命令填充数据库数据

```
php artisan db:seed
```

### 生成网站链接
```
php artisan serve

Laravel development server started: <http://127.0.0.1:8000>
http://127.0.0.1:8000为该网站的临时地址
```

### 如需使用钉钉通知群则需在.env中添加
```
DINGTALK_TOKEN=your token
```
```
(your token为你钉钉群添加机器人的access_token)
在机器人管理页面选择“自定义”机器人，输入机器人名字并选择要发送消息的群。
如果需要的话，可以为机器人设置一个头像。点击“完成添加”。

点击“复制”按钮，即可获得这个机器人对应的Webhook地址，其格式如下

https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx
```

### 如需发送邮件功能请配置mail(暂时实现163邮箱)
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.163.com
MAIL_PORT=465
MAIL_USERNAME=你的163邮箱地址
MAIL_PASSWORD=你的163邮箱地址对应的授权密码（不是登录密码）
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=你的163邮箱地址
MAIL_FROM_NAME=你期望的发件人名称
```

### 后台

描述 | 详情
--- |---
后台登录地址 | http://127.0.0.1:8000/admin/auth/login
账号 | admin
密码 | admin
菜单管理地址 | http://127.0.0.1:8000/admin/auth/menu
员工管理路径 | users
部门管理路径 | departments
工资管理路径 | wages
离职员工管理路径 | quit_users

```
进入菜单管理地址，新增板块可方便进入，路径上述已给出
也可执行命令来添加菜单地址
php artisan add_admin_menu_data
员工管理与工资管理均为软删除，删除之后的信息如想查看，可进入数据库进行查看
```
**==================================后台截图==================================**

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/login.png)

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/index.png)

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/users.png)

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/menu.png)

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/logs.png)

![image](https://github.com/WXiangQian/wage-cms/raw/master/demo/express.png)

如有问题可添加我QQ：175023117
（备注：GitHub）
