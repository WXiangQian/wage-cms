# wage-cms  
基于laravel-admin开发的工资管理系统，针对于中小型企业

### 克隆仓库
```
git clone git@github.com:qq175023117/wage-cms.git
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
员工管理与工资管理均为软删除，删除之后的信息如想查看，可进入数据库进行查看
```


如有问题可添加我QQ：175023117
（备注：GitHub）