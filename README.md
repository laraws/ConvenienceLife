# Introduction

生活信息查询项目, 目前支持天气和物流查询

支持功能:

1.用户系统
  
  支持用户注册登录, 支持使用邮箱注册帐号, 支持邮箱验证用户和重置密码
  
2.天气系统

  登录用户查询天气, 并记录到查询列表, 天气数据定时更新, 支持设置邮箱定时收取天气信息
  
3.物流系统

   登录用户支持物流查询, 并记录到查询列表, 物流是数据定时更新, 支持设置邮箱定时收取物流信息
   
技术栈

- docker的应用
- composer扩展包的开发
- redis消息队列
- redis数据持久化
- 使用定时任务发送邮件和更新数据  

## Installation

前提:

- docker
- docker-compose

### 复制项目

```bash
https://github.com/laraws/ConvenienceLife.git
```

### 安装项目

运行docker-compose文件一键部署项目运行环境

```bash
cd ConvenienceLife
docker-compose up -d
```

配置项目

```bash
cp .env.example .env
```

```bash
vim .env
```

配置env中的database

```dotenv
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=conveniencelife
DB_USERNAME=laraveluser
DB_PASSWORD=123456
```

配置key

```bash
docker-compose exec app php artisan key:generate
```

配置mysql

```bash
docker-compose exec db bash
```


```bash
mysql -u root -p
```


```bash
show databases;
```

```bash
GRANT ALL ON conveniencelife.* TO 'laraveluser'@'%' IDENTIFIED BY '123456';
```

```bash
FLUSH PRIVILEGES;
```

```bash
EXIT;
```

laravel数据迁移

```bash
docker-compose exec app php artisan migrate
```

```bash
docker-compose exec app php artisan db:seed
```

## 测试运行效果

访问`127.0.0.1`



