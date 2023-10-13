FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm
RUN composer i \
    && php artisan generate:key --env=dev \
    && php artisan migrate --env=dev \
    && php artisan serve --env=dev