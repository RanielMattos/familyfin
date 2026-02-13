# FamilyFin Snapshot

- Generated at: `2026-02-13T12:00:22.1895340-03:00`
- Repo root: `C:/Users/nitro/OneDrive/Documentos/Familyfin novo/familyfin`

## Git

- Branch: `chore/snapshot-update`
- HEAD: `0f6123b`
- Upstream: `none`

### Status

```
## chore/snapshot-update
```

### Last 15 commits

```
0f6123b Add family members management (roles + UI) (#40)
554038a Update snapshots (LATEST + FULL) (#39)
03b617a Fix incomes tenancy: scopeBindings + harden IncomeFlowTest (#38)
11fd65d Fix/incomes policy (#37)
b029d8d Add IncomePolicy (tenancy) + auto snapshot post-commit hook (#35)
aafacd8 Improve incomes UI (table, edit, delete, totals) (#34)
23db586 Add Receitas link to family navigation (#33)
c11536f Update snapshots (#32)
53bafd8 Track snapshot docs (LATEST + FULL) (#31)
a537808 Add incomes feature (tenancy scoped) + IncomeFlowTest (#30)
a981ae8 chore(docs): harden full snapshot script (ascii + robust config:show) (#29)
4e52acd chore(docs): add snapshot system (latest + full) (#28)
dea1acc chore(git): protect main with local hooks (#27)
ae54ec1 feat(planpag): allow custom paid amount on mark paid (#26)
588c073 test(planpag): cover unmark paid flow (#25)
```

### Diff stat (working tree)

```
(no output)
```

## Local main protection (githooks)

- core.hooksPath: `.githooks`

### .githooks listing

```

Mode   Length LastWriteTime       Name       
----   ------ -------------       ----       
-a----    759 11/02/2026 14:52:42 post-commit
-a----    290 27/01/2026 21:33:38 pre-commit 
-a----    686 27/01/2026 21:33:38 pre-push
```

## Runtime

### PHP version

```
PHP 8.2.12 (cli) (built: Oct 24 2023 21:15:15) (ZTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.2.12, Copyright (c) Zend Technologies
```

### Composer version

```
[32mComposer[39m version [33m2.8.12[39m 2025-09-19 13:41:59
[32mPHP[39m version [33m8.2.12[39m (C:\.xampp\php\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.
```

### Laravel / Artisan version

```
Laravel Framework 12.48.1
```

## Environment (redacted)

- .env: present âœ…

### Selected keys

```
APP_ENV=***REDACTED***
APP_URL=***REDACTED***
APP_DEBUG=***REDACTED***
DB_CONNECTION=***REDACTED***
QUEUE_CONNECTION=***REDACTED***
SESSION_DRIVER=***REDACTED***
MAIL_MAILER=***REDACTED***
```

- .env.example: present âœ…

## Key project files (fingerprints)

- `routes/web.php` SHA1: `65a02c788509ded20b954db4fb246e111c1b6842`
- `app/Http/Controllers/FamilyPlanpagActionsController.php` SHA1: `ba9e67bbc0b46993d9f805ccaf828facb224f9e0`
- `resources/views/family/planpag.blade.php` SHA1: `210b29676169247478ea186304637bb6bd04d2ad`
- `tests/Feature/PlanpagUiPageTest.php` SHA1: `55d97d8a3b5ce9f0a0b84e29f56d9062ab46bfd6`
- `.githooks/pre-commit` SHA1: `f6d651ab801d828b969e53130886ccac08072177`
- `.githooks/pre-push` SHA1: `e2ac7681c750b0132801eb28370b3ee008b02596`

## PlanPag quick scan

### Matches in routes/web.php

```
8: use App\Http\Controllers\FamilyPlanpagPageController;
9: use App\Http\Controllers\FamilyPlanpagActionsController;
11: use App\Http\Controllers\PlanpagController;
35: Route::get('/planpag', [PlanpagController::class, 'index']);
90:             // PlanPag UI
91:             Route::get('/planpag', FamilyPlanpagPageController::class)
92:                 ->name('family.planpag');
94:             // PlanPag actions
95:             Route::post('/planpag/{occurrence}/mark-paid', [FamilyPlanpagActionsController::class, 'markPaid'])
96:                 ->name('family.planpag.markPaid');
98:             Route::post('/planpag/{occurrence}/unmark-paid', [FamilyPlanpagActionsController::class, 'unmarkPaid'])
99:                 ->name('family.planpag.unmarkPaid');
```

## Routes

### PlanPag routes (filtered from route:list)

```
  GET|HEAD        f/{family}/planpag family.planpag ÔÇ║ FamiÔÇª
  POST            f/{family}/planpag/{occurrence}/mark-paid family.planpag.markPaid ÔÇ║ FamilyPlanpagActionsController@markPaÔÇª
  POST            f/{family}/planpag/{occurrence}/unmark-paid family.planpag.unmarkPaid ÔÇ║ FamilyPlanpagActionsController@unmarkÔÇª
  GET|HEAD        planpag ......... PlanpagController@index
```

### Full route:list

- Saved to: `docs\snapshots\routes_full_20260213_120022.txt`

## Notes

- Snapshot redacts secrets by default.
- If route:list / migrate:status fails, it is captured as text and does not stop the snapshot.
