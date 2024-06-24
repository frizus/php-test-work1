## О репозитории

Тестовое задание сделать админку с заполнением пользователями TODO списков задач.
Аутентификация, регистрация, админка (CRUD, поиск/фильтрация) - `filament`

Пользователь может создавать список задач, туда вносить задачи (состоящие из названия, картинки, тегов)

На отсутствие перевода не обращал внимания. Доп. задачи не делал

## Системные требования

* PHP >= 8.3.8
* Node.js >= 22.3.0
* SQLite3

# Установка

Если нет своей рабочей среды с `php-8.3.8`, можно установить конфигурацию `Docker` для `WSL2` отсюда https://github.com/frizus/phpdocker/tree/for-php-test-work1
```sh
git clone -b for-php-test-work1 https://github.com/frizus/phpdocker.git php-test-work1/
```
Дальше смотреть [README.md](https://github.com/frizus/phpdocker/blob/for-php-test-work1/README.md) оттуда

ИЛИ

Если есть своя среда:
```sh
make install
make test # запускает тесты
```

# Заняло времени
1. Установка php 8.3.8, nginx, nodejs на Docker, настройка xdebug, Laravel 11 - 11.2 часов
2. Настройка админки (Filament) - 9.5 часов
   * Регистрация, авторизация пользователей (встроено)
   * Миграции для списка задач, задач
   * CRUD для списка задач (встроены задачи)
   * Поиск по названию задачи
   * Загрузка картинок [filament/spatie-laravel-media-library-plugin](https://github.com/filamentphp/spatie-laravel-media-library-plugin)
   * Создание тегов, поиск по тегам [filament/spatie-laravel-tags-plugin](https://filamentphp.com/plugins/filament-spatie-tags)
   * Разграничение прав пользователей на просмотр своих сущностей [althinect/filament-spatie-roles-permissions](https://github.com/Althinect/filament-spatie-roles-permissions)
3. Полировка, сидер, тесты (не будет, погружаться в livewire/filament, чтобы делать Feature-тесты
проверки прав слишком долго), линтер, настройка воркфлоу (нечего тестировать - не будет) - 2.4 часа

# Известные баги
[Filament Spatie Media Library Plugin](https://github.com/filamentphp/spatie-laravel-media-library-plugin) не удаляет
отдельные папки, созданные для картинок задачи, когда задача удаляется
