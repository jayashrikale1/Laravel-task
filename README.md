# Laravel Practical Test – User & Task Management System

## Requirements

- PHP 8.2+
- Composer
- Laravel Framework 12.46.0
- MySQL

## Setup (MySQL)

1) Create a database named `laraveltask`.

2) Install dependencies and configure env:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh
php artisan serve
```

Open: http://127.0.0.1:8000



## Features

- Users CRUD with validation (name required, email unique, mobile 10 digits)
- Tasks CRUD (belongs to users) with due date validation (no past dates when creating)
- User listing includes total tasks and completed tasks counts
- Task listing supports filters and highlights overdue pending tasks

## API

```http
GET /api/users/{id}/tasks
```
