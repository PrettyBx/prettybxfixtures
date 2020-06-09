# Фикстуры для тестирования

![Phpunit](https://github.com/artem-prozorov/prettybxfixtures/workflows/Phpunit/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/artem-prozorov/prettybxfixtures/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/artem-prozorov/prettybxfixtures/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/artem-prozorov/prettybxfixtures/badges/build.png?b=master)](https://scrutinizer-ci.com/g/artem-prozorov/prettybxfixtures/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/artem-prozorov/prettybxfixtures/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

## Установка
Рекомендуется устанавливать только для разработки
`composer require-dev prettybx/fixtures`

## Настройка
В файле `bitrix/.settings.php` нужно добавить ключ `fixture_path`, в котором указать путь к директории, где будут размещаться фикстуры. Рекомендуется размещать фикстуры на 1 уровень выше, чем DOCUMENT_ROOT, чтобы веб-сервер не имел к ним доступа.
Например:
```
'fixture_path' => realpath(__DIR__ . '/../../fixtures'),
```

После того, как укажете путь к нужной директории в конфигурации Битрикс, зарегистрируйте сервис провайдер. Так как данная библиотека нужна в основном для тестирования, то имеет смысл инициализировать ее только для тестового окружения.
```
(new \PrettyBx\Fixtures\FixtureServiceProvider())->register();
```

## Использование
Для примера создадим фикстуру, описывающую массив с данными пользователя. В каталоге с фикстурами создайте файл `user.php`, который должен возвращать массив нужной структуры:
```
<?php

return [
    'ID' => 1,
    'FIRST_NAME' => 'Ivan',
    'LAST_NAME' => 'Petrov',
];
```

Теперь в тесте вы можете получить эти данные следующим образом:
```
$user = fixture()->make('user');
```

Вы можете переписать нужные данные, если передадите их вторым аргументом в метод `make`:
```
$user = fixture()->make('user', ['ID' => 17]); // Вернет фикстуру с ID => 17
```

### Автоматическая генерация данных
Библиотека интегрирована с `fzaninotto/Faker`. Faker предоставляет удобный инструмент для автоматической генерации данных в нужном виде. Пример описания фикстуры:
```
<?php

return [
    'ID' => faker()->randomDigit,
    'FIRST_NAME' => faker()->firstName,
    'LAST_NAME' => faker()->lastName,
];
```

Документация по библиотеке Faker размещена в гитхабе проекта: https://github.com/fzaninotto/Faker

### Генерация массива с фикстурами
Для того, чтобы сгенерировать массив фикстур, можно воспользоваться методом `makeMany`:
```
$users = fixture()->makeMany('user', 3); // Вернет массив, состоящий из 3 фикстур типа user
```
