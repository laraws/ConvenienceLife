-   [ConvenienceLife](#conveniencelife)
    -   [简介](#简介)
    -   [功能](#功能)
    -   [技术栈](#技术栈)
    -   [Installation](#installation)
        -   [复制项目](#复制项目)
        -   [配置项目](#配置项目)
            -   [env](#env)
                -   [数据库](#数据库)
                -   [redis](#redis)
                -   [邮箱配置](#邮箱配置)
                -   [物流和天气配置](#物流和天气配置)
        -   [docker运行和配置](#docker运行和配置)
            -   [运行](#运行)
            -   [配置](#配置)
                -   [配置laravel key](#配置laravel-key)
                -   [配置mysql](#配置mysql)
                -   [laravel数据迁移](#laravel数据迁移)
        -   [定时任务配置](#定时任务配置)
    -   [测试运行效果](#测试运行效果)
    -   [项目交流](#项目交流)

ConvenienceLife
===============

简介
----

生活信息查询项目,
目前登录用户进行支持天气和物流查询并对天气物流动态进行邮件更新提醒

功能
----

支持功能:

1.用户系统

支持用户注册登录, 支持使用邮箱注册帐号, 支持邮箱验证用户和重置密码

2.天气系统

登录用户查询天气, 并记录到查询列表, 天气数据定时更新,
支持设置邮箱定时收取天气信息

3.物流系统

登录用户支持物流查询, 并记录到查询列表, 物流是数据定时更新,
支持设置邮箱定时收取物流信息

技术栈
------

-   docker的应用

    docker image的搭建和docker-compse的使用, 快速搭建和部署项目

-   composer扩展包的开发

    引入个人开发的查询天气和物流的composer扩展包进行天气和物流的查询

-   redis消息队列

    使用消息队列进行邮件通知的异步发送

-   定时任务

    使用crontab配合laravel command进行定时更新数据和发送邮件通知

-   redis数据持久化

    redis配置aof方式进行数据的持久化, 防止数据断电丢失

-   webpack前端打包

    编写scss和js并使用webpack编译和打包处理, 增强前端的可维护性和高效性
    
-   https加密

    网站全站使用https加密，访问http自动定向https网站

Installation
------------

前提:

-   docker
-   docker-compose
-   crontab

### 复制项目

``` {.bash}
https://github.com/laraws/ConvenienceLife.git
```

### 配置项目

    cd ConvenienceLife

``` {.bash}
cp .env.example .env
```

``` {.bash}
vim .env
```

#### env

##### 数据库

配置env中的database, 根据自己的需要配置数据库的相关信息,
这些信息在docker环境构建的时候将自动配置到docker容器中

``` {.dotenv}
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=


DB_PORT_DOCKER=3306
DB_DATABASE_DOCKER=
DB_USERNAME_DOCKER=
DB_PASSWORD_DOCKER=
```

##### redis

    REDIS_HOST=redis
    REDIS_PASSWORD=
    REDIS_PORT=6379

    REDIS_HOST_DOCKER=redis
    REDIS_PASSWORD_DOCKER=
    REDIS_PORT_DOCKER=6379

##### 邮箱配置

    MAIL_MAILER=smtp
    MAIL_HOST=
    MAIL_PORT=465
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS=

##### 物流和天气配置

填入自己的物流和天气密钥

物流使用极速数据: https://www.jisuapi.com/api/express/

天气使用高德数据:https://console.amap.com/dev

    WEATHER_API_KEY=
    EXPRESS_API_KEY=

### docker运行和配置

#### 运行

    docker-compose up -d 

#### 配置

##### 配置laravel key

``` {.bash}
docker-compose exec app php artisan key:generate
```

##### 配置mysql

``` {.bash}
docker-compose exec db bash
```

``` {.bash}
mysql -u root -p
```

``` {.bash}
show databases;
```

``` {.bash}
GRANT ALL ON conveniencelife.* TO 'laraveluser'@'%' IDENTIFIED BY '123456';
```

``` {.bash}
FLUSH PRIVILEGES;
```

``` {.bash}
EXIT;
```

##### laravel数据迁移

``` {.bash}
docker-compose exec app php artisan migrate
```

``` {.bash}
docker-compose exec app php artisan db:seed
```

### 定时任务配置

由于docker到crontab支持存在问题,
本项目使用宿主机的crontab来管理docker项目中的定时任务

``` {.bash}
$ cd ./docker-config/php/crontab
$ cat host-cron
# 复制host-cron内的定时任务数据
$ crontab -e
# 粘贴数据到crontab 编辑内容中,并保存
```

项目定时任务配置完成

测试运行效果
------------

访问 http://localhost

项目交流
--------

1.  提出issue

2.  发送邮件to: larawsw\@outlook.com
