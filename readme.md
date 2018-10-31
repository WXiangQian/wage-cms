# wage-cms  
基于laravel-admin开发的工资管理系统，针对于中小型企业

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

### 后台
```
登陆地址为所配置的域名+/admin
账号：admin 
密码：admin
所配置的域名+/admin/auth/menu进行菜单管理
员工管理为users
部门管理为departments
工资管理为wages
员工管理与工资管理均为软删除，删除之后的信息如想查看，可进入数据库进行查看
```

如有问题可添加我QQ：175023117
（备注：GitHub）