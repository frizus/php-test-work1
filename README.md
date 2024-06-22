## О репозитории

Тестовое задание сделать TODO дополнить

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
2. Настройка админки (Filament) - 1 час (в процессе)

TODO дополнить
