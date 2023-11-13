
# Amotive-Tech Unified Search SDK
*Документация: [doc.a-motive.ru](https://doc.a-motive.ru)*

## Установка

Выполнить команду

    composer require automotive/usearch

## Использование

Необходимо импортировать классы Config и UnifiedSearchService. Например:

```php
use AmotiveTech\UnifiedSearch\Config;
use AmotiveTech\UnifiedSearch\USService;


$service = new USService(new Config(['login' => $login, 'password' => $password]));
```

Далее можно использовать методы экземпляра USService для получения данных веб-сервиса:

```php
    print_r($service->user());
    print_r($service->search('фильтр маслянный XW8ZZZ7PZHG003807'));
```
