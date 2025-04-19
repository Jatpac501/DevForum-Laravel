# DevForum-Laravel

Форум-приложение, разработанное на Laravel 11, предоставляющее платформу для обсуждений и взаимодействия пользователей.

## О проекте

DevForum - это веб-приложение для создания и управления форумами. Проект построен на 11 версии Laravel и использует стек технологий для обеспечения отзывчивого и удобного пользовательского интерфейса.

### Используемые технологии:

- **Backend:**
  - Laravel 11.x
  - PHP 8.2+
  - Laravel Breeze (аутентификация)
  - Laravel Tinker
  - SQLite (по умолчанию)

- **Frontend:**
  - Vite
  - TailwindCSS
  - Alpine.js
  - Axios

## Установка

1. Клонируйте репозиторий:
```bash
git clone <repository_url>
cd DevForum-Laravel
```

2. Установите PHP-зависимости:
```bash
composer install
```

3. Настройте окружение:
```bash
cp .env.example .env
php artisan key:generate
```

4. Настройте базу данных в файле `.env`:
```
DB_CONNECTION=sqlite
# Или для MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

5. Выполните миграции:
```bash
php artisan migrate
```

6. Установите фронтенд-зависимости и соберите ресурсы:
```bash
npm install
npm run dev
```

## Конфигурация

Основные параметры конфигурации в файле `.env`:

- `APP_NAME` - название приложения
- `APP_ENV` - окружение (local/production)
- `APP_DEBUG` - режим отладки
- `APP_URL` - URL приложения
- `APP_TIMEZONE` - часовой пояс
- `APP_LOCALE` - язык приложения

Настройки базы данных:
- `DB_CONNECTION` - тип базы данных
- `DB_HOST` - хост базы данных
- `DB_PORT` - порт базы данных
- `DB_DATABASE` - имя базы данных
- `DB_USERNAME` - имя пользователя
- `DB_PASSWORD` - пароль

Дополнительные настройки:
- `SESSION_DRIVER` - драйвер сессий
- `QUEUE_CONNECTION` - драйвер очередей
- `CACHE_STORE` - драйвер кэширования
- `MAIL_MAILER` - драйвер почты

## Использование

1. Запустите локальный сервер:
```bash
php artisan serve
```

2. В отдельном терминале запустите сборку фронтенда:
```bash
npm run dev
```

3. Откройте приложение в браузере:
```
http://127.0.0.1:8000
```

## Тестирование

Проект использует Pest PHP для тестирования. Запустите тесты командой:
```bash
php artisan test
```

## Вклад в разработку

1. Форкните репозиторий
2. Создайте ветку для ваших изменений (`git checkout -b feature/amazing-feature`)
3. Зафиксируйте изменения (`git commit -m 'Add some amazing feature'`)
4. Отправьте изменения в ваш форк (`git push origin feature/amazing-feature`)
5. Создайте Pull Request

## Лицензия

Проект распространяется под лицензией MIT. См. файл `LICENSE` для получения дополнительной информации.
