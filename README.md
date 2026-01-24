# FamilyFin

Sistema web (futuro app) de organização financeira familiar: orçamento por competência (cenários) + planejamento de pagamentos (PlanPag).

## Requisitos
- PHP 8.2+
- Composer
- Git
- (Opcional) Node/Vite para UI depois

## Setup (primeira execução)
```bash
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
php artisan test
php artisan serve
