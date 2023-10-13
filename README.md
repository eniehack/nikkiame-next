## nikkiame-next

### install

1. `git clone` & `cd`
2. install `php` 8.1 or later.
3. install php module
3. install composer
5. setup webserver(e.g. Nginx&php-fpm, Apache, etc...)

### for Developers

#### use dev-container & VSCode

1. `git clone` & `cd`
2. install [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extentions
3. open this repo in Dev Container
4. run `composer i`
5. run `php artisan key:generate --env=dev`
6. run `php artisan migrate --env=dev`
7. run `php artisan serve --env=dev`