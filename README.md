## install

### requirements

- php >= 8.1

## for developer

### Debian / Ubuntu

1. install php and dependencies

```shell-session
sudo apt install php php-common php-curl php-sqlite3 php-mbstring php-xml composer
```

2. git clone && cd 

3. install php library
```shell-session
composer i
```

4. generate security key
```shell-session
php artisan key:generate --env=dev
```

5. re-cache config
```shell-session
DB_DATABASE="$(pwd)/database/test.sqlite" php artisan config:cache --env=dev
```

6. run migration
```shell-session
DB_DATABASE="$(pwd)/database/test.sqlite" php artisan migrate --env=dev
```

7. run app
```shell-session
DB_DATABASE="$(pwd)/database/test.sqlite" php artisan serve --env=dev
```