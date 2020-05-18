## install project

### config laravel

```bash
cp .env.example .env
```

```bash
vim .env
```

Find the block that specifies DB_CONNECTION and update it to reflect the specifics of your setup. You will modify the following fields:

```dotenv
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=conveniencelife
DB_USERNAME=laraveluser
DB_PASSWORD=123456
```

```bash
docker-compose exec app php artisan key:generate
```

```bash
docker-compose exec app php artisan config:cache
```

### config mysql

```bash
docker-compose exec db bash
```

in db bash

```bash
mysql -u root -p
```

in mysql db

```bash
show databases;
```
you can find the `laravel` database.

db grant, run command in mysql db

```bash
GRANT ALL ON conveniencelife.* TO 'laraveluser'@'%' IDENTIFIED BY '123456';
```

```bash
FLUSH PRIVILEGES;
```

```bash
EXIT;
```

### laravel database migration and test

```bash
docker-compose exec app php artisan migrate
```

```bash
docker-compose exec app php artisan tinker
\DB::table('migrations')->get();
```




