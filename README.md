# FamilyFin
![CI](https://github.com/RanielMattos/familyfin/actions/workflows/ci.yml/badge.svg)

Sistema web (futuro app) para organização financeira familiar: **Orçamento por competência (cenários)** + **Planejamento de Pagamentos (PlanPag)**, com multi-tenant por família e base pronta para evoluir em dashboard e importação de planilhas.

## O que já existe (Fase 0)
- Multi-tenant por família (Family / FamilyMember)
- Taxonomia base (grupos/categorias) com seed + endpoint JSON
- Orçamento por competência (Scenario / BudgetLine / BudgetEntry)
- PlanPag (Bill / BillOccurrence) + listagem por período
- Testes automatizados cobrindo o núcleo

## Requisitos
- PHP 8.2+
- Composer
- SQLite (arquivo)
- Git

## Setup rápido (primeira execução)
```bash
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
php artisan test
php artisan serve

# test protection
