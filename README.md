# Introduction

生活信息查询项目, 目前支持天气和物流查询

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



