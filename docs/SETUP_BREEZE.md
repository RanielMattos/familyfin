# Setup local (Laravel Breeze + SQLite)

Este projeto usa SQLite por arquivo e inclui UI de autenticação (Breeze Blade).

## Requisitos
- PHP 8.2+
- Composer
- Node 20+ (npm)
- SQLite

---

## Setup rápido (PowerShell)
```powershell
cp .env.example .env
php artisan key:generate

# SQLite (arquivo)
if (!(Test-Path "database/database.sqlite")) { New-Item -ItemType File -Path "database/database.sqlite" | Out-Null }

php artisan migrate
npm ci
npm run build

php artisan test
php artisan serve
