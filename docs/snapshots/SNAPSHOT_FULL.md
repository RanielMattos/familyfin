# FamilyFin FULL Snapshot (maximal, safe-redacted)

- Generated at: `2026-02-13T18:36:41.5337206-03:00`
- Repo root: `C:/Users/nitro/OneDrive/Documentos/Familyfin novo/familyfin`
- Branch: `main`
- HEAD: `d8e4164`
- Upstream: `origin/main`
- Safety: secrets redacted = ON


## Git - Overview


### Remotes

```
origin	https://github.com/RanielMattos/familyfin.git (fetch)
origin	https://github.com/RanielMattos/familyfin.git (push)
```

### Status

```
## main...origin/main
 M docs/snapshots/SNAPSHOT_LATEST.md
```

### Last 50 commits

```
d8e4164 RBAC: authorize bills and planpag via policies (#44)
40e2265 Feat/rbac family members policy (#43)
2303869 RBAC: add family role helpers and authorize incomes via policies (#42)
47bf31e Update snapshots (LATEST + FULL) (#41)
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
8ea343e feat(planpag): toggle paid action on UI (#24)
0baedee feat(planpag): unmark occurrence as paid (#23)
00bc96a feat(planpag): mark occurrence as paid (#22)
5163e23 feat(planpag): add occurrence generator and command (#21)
0042b1e feat(bills): toggle active status (#20)
e7aad12 fix(bills): prevent deleting bills with occurrences (#19)
1367eda feat(bills): add edit and delete flows (#18)
dd8f5e4 fix(bills): redirect to index after create (#17)
21e9275 feat(bills): add family-scoped bills UI (#16)
4488523 feat(planpag): add family scoped UI page (#15)
8bc65b8 feat(tenancy): auto-activate family on scoped routes (#14)
fca0558 refactor(tenancy): centralize family activation (#13)
74f4dbe feat(tenancy): auto-activate family on enter (#12)
a7eb52b feat(tenancy): active family redirect + activation (#10)
96cf942 feat(ui): family dashboard + public endpoints (#9)
b9d899c feat: create family on registration (#8)
77e5a22 fix: normalize family member role to lowercase (#7)
19f6a39 Revert "test: try push directly to main (#5)" (#6)
b6aa7cc test: try push directly to main (#5)
9d785f8 docs: add breeze setup guide (#4)
499369a Feat/auth UI skeleton (#3)
124bbcb docs: add contributing guide (#1)
fff2609 docs: add ci badge
0b88f44 docs: improve README
9ead7fc ci: add github actions workflow
6c99ef4 chore: normalize line endings
0d89ba0 docs: add project README
dbbacb6 chore: add root healthcheck route
6b9da56 feat: add planpag core and endpoint
7193e81 feat: add scenarios and budget core
e68a8a2 feat: add taxonomy seed and endpoint
```

### First commit + total commits

```
bb9dcf95527951ee44f43c6fe046a99bda125b42
```
```
52
```

## Git - Deep


### Branches (local + remote)

```
  chore/guard-main
  chore/snapshot-update
  feat/rbac-bills-planpag
  feat/rbac-roles
  fix/incomes-policy
  fix/incomes-tenancy
* main
  remotes/origin/HEAD -> origin/main
  remotes/origin/RanielMattos-patch-1
  remotes/origin/chore/snapshot-update
  remotes/origin/chore/track-snapshots
  remotes/origin/feat/incomes-ui
  remotes/origin/feat/menu-receitas
  remotes/origin/feat/rbac-bills-planpag
  remotes/origin/feat/rbac-family-members-policy
  remotes/origin/feat/rbac-roles
  remotes/origin/fix/incomes-policy
  remotes/origin/fix/incomes-scope-bindings
  remotes/origin/fix/incomes-tenancy
  remotes/origin/main
  remotes/origin/revert-35-fix/incomes-policy
```

### Tags

```
(no output)
```

### Describe

```
d8e4164-dirty
```

### Submodules

```
(no output)
```

### Working tree diff stat

```
 docs/snapshots/SNAPSHOT_LATEST.md | 34 +++++++++++++++-------------------
 1 file changed, 15 insertions(+), 19 deletions(-)
```

### Tracked files (paths)

```
.editorconfig
.env.example
.gitattributes
.githooks/post-commit
.githooks/pre-commit
.githooks/pre-push
.github/workflows/ci.yml
.gitignore
CONTRIBUTING.md
README.md
app/Console/Commands/GenerateBillOccurrences.php
app/Console/Kernel.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
app/Http/Controllers/Auth/ConfirmablePasswordController.php
app/Http/Controllers/Auth/EmailVerificationNotificationController.php
app/Http/Controllers/Auth/EmailVerificationPromptController.php
app/Http/Controllers/Auth/NewPasswordController.php
app/Http/Controllers/Auth/PasswordController.php
app/Http/Controllers/Auth/PasswordResetLinkController.php
app/Http/Controllers/Auth/RegisteredUserController.php
app/Http/Controllers/Auth/VerifyEmailController.php
app/Http/Controllers/Controller.php
app/Http/Controllers/DashboardController.php
app/Http/Controllers/FamilyBillsController.php
app/Http/Controllers/FamilyController.php
app/Http/Controllers/FamilyDashboardController.php
app/Http/Controllers/FamilyIncomesController.php
app/Http/Controllers/FamilyMembersController.php
app/Http/Controllers/FamilyPlanpagActionsController.php
app/Http/Controllers/FamilyPlanpagPageController.php
app/Http/Controllers/PlanpagController.php
app/Http/Controllers/ProfileController.php
app/Http/Controllers/TaxonomyController.php
app/Http/Middleware/AutoActivateFamily.php
app/Http/Middleware/EnsureFamilyAccess.php
app/Http/Requests/Auth/LoginRequest.php
app/Http/Requests/ProfileUpdateRequest.php
app/Http/Requests/StoreBillRequest.php
app/Models/Bill.php
app/Models/BillOccurrence.php
app/Models/BudgetEntry.php
app/Models/BudgetLine.php
app/Models/Family.php
app/Models/FamilyMember.php
app/Models/Income.php
app/Models/Scenario.php
app/Models/TaxonomyNode.php
app/Models/User.php
app/Policies/BillOccurrencePolicy.php
app/Policies/BillPolicy.php
app/Policies/FamilyMemberPolicy.php
app/Policies/IncomePolicy.php
app/Providers/AppServiceProvider.php
app/Services/BillOccurrenceGenerator.php
app/Services/FamilyActivationService.php
app/Services/PlanpagService.php
app/View/Components/AppLayout.php
app/View/Components/GuestLayout.php
artisan
bin/familyfin-full.ps1
bin/familyfin-snapshot.ps1
bin/familyfin-snapshot.sh
bin/snapshot.ps1
bootstrap/app.php
bootstrap/cache/.gitignore
bootstrap/providers.php
composer.json
composer.lock
config/app.php
config/auth.php
config/cache.php
config/database.php
config/filesystems.php
config/logging.php
config/mail.php
config/queue.php
config/services.php
config/session.php
database/.gitignore
database/factories/BillFactory.php
database/factories/BillOccurrenceFactory.php
database/factories/BudgetEntryFactory.php
database/factories/BudgetLineFactory.php
database/factories/FamilyFactory.php
database/factories/FamilyMemberFactory.php
database/factories/IncomeFactory.php
database/factories/ScenarioFactory.php
database/factories/UserFactory.php
database/migrations/0001_01_01_000000_create_users_table.php
database/migrations/0001_01_01_000001_create_cache_table.php
database/migrations/0001_01_01_000002_create_jobs_table.php
database/migrations/2026_01_23_213624_create_families_table.php
database/migrations/2026_01_23_213625_create_family_members_table.php
database/migrations/2026_01_23_221245_create_taxonomy_nodes_table.php
database/migrations/2026_01_23_222836_create_budget_lines_table.php
database/migrations/2026_01_23_222837_create_budget_entries_table.php
database/migrations/2026_01_23_223001_create_scenarios_table.php
database/migrations/2026_01_23_224940_create_bills_table.php
database/migrations/2026_01_23_225122_create_bill_occurrences_table.php
database/migrations/2026_02_04_145800_create_incomes_table.php
database/seeders/DatabaseSeeder.php
database/seeders/IncomeSeeder.php
database/seeders/TaxonomySeeder.php
docs/SETUP_BREEZE.md
docs/snapshots/SNAPSHOT_FULL.md
docs/snapshots/SNAPSHOT_LATEST.md
package-lock.json
package.json
phpunit.xml
postcss.config.js
public/.htaccess
public/favicon.ico
public/index.php
public/robots.txt
resources/css/app.css
resources/js/app.js
resources/js/bootstrap.js
resources/views/auth/confirm-password.blade.php
resources/views/auth/forgot-password.blade.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/auth/reset-password.blade.php
resources/views/auth/verify-email.blade.php
resources/views/components/application-logo.blade.php
resources/views/components/auth-session-status.blade.php
resources/views/components/danger-button.blade.php
resources/views/components/dropdown-link.blade.php
resources/views/components/dropdown.blade.php
resources/views/components/input-error.blade.php
resources/views/components/input-label.blade.php
resources/views/components/modal.blade.php
resources/views/components/nav-link.blade.php
resources/views/components/primary-button.blade.php
resources/views/components/responsive-nav-link.blade.php
resources/views/components/secondary-button.blade.php
resources/views/components/text-input.blade.php
resources/views/dashboard.blade.php
resources/views/family/bills/create.blade.php
resources/views/family/bills/edit.blade.php
resources/views/family/bills/index.blade.php
resources/views/family/dashboard.blade.php
resources/views/family/incomes/index.blade.php
resources/views/family/members/index.blade.php
resources/views/family/planpag.blade.php
resources/views/layouts/app.blade.php
resources/views/layouts/guest.blade.php
resources/views/layouts/navigation.blade.php
resources/views/planpag/index.blade.php
resources/views/profile/edit.blade.php
resources/views/profile/partials/delete-user-form.blade.php
resources/views/profile/partials/update-password-form.blade.php
resources/views/profile/partials/update-profile-information-form.blade.php
resources/views/welcome.blade.php
routes/auth.php
routes/console.php
routes/web.php
storage/app/.gitignore
storage/app/private/.gitignore
storage/app/public/.gitignore
storage/framework/.gitignore
storage/logs/.gitignore
tailwind.config.js
tests/Feature/ActiveFamilyFlowTest.php
tests/Feature/Auth/AuthenticationTest.php
tests/Feature/Auth/EmailVerificationTest.php
tests/Feature/Auth/PasswordConfirmationTest.php
tests/Feature/Auth/PasswordResetTest.php
tests/Feature/Auth/PasswordUpdateTest.php
tests/Feature/Auth/RegistrationTest.php
tests/Feature/BillOccurrenceGeneratorTest.php
tests/Feature/BillPaymentFlowTest.php
tests/Feature/BillsUiFlowTest.php
tests/Feature/BudgetBasicsTest.php
tests/Feature/EnterActivatesFamilyTest.php
tests/Feature/ExampleTest.php
tests/Feature/FamilyAccessMiddlewareTest.php
tests/Feature/FamilyMembersFlowTest.php
tests/Feature/IncomeFlowTest.php
tests/Feature/PlanpagEndpointTest.php
tests/Feature/PlanpagUiPageTest.php
tests/Feature/ProfileTest.php
tests/Feature/ScopedRoutesAutoActivateFamilyTest.php
tests/Feature/TaxonomyEndpointTest.php
tests/Feature/TenancyIsolationTest.php
tests/TestCase.php
tests/Unit/ExampleTest.php
vite.config.js
```

### Tracked files (tree with blob ids + sizes)

```
100644 blob a186cd2079e78c66fca5e037bafa0917818116df     252	.editorconfig
100644 blob c0660ea143a7a23e6a182cbe42dbd7fc6e242b45    1086	.env.example
100644 blob b9648bec3996b14b4fdb00d8a5066e36d24f51a8      78	.gitattributes
100644 blob 67e110b0e4b8ea8d503e8dfe7d1a93c1831a91ca     759	.githooks/post-commit
100755 blob 3da66e4936ba7a74aa85b35feb7bddfcd0d64530     290	.githooks/pre-commit
100755 blob 67acce5880c43d6c6d04c45c900bbe6816565ecb     686	.githooks/pre-push
100644 blob 341d0154fa5df89bf0b3877eece02ec7ff4c62e8    1401	.github/workflows/ci.yml
100644 blob d23282dfa342d044f7a4df9e108c13be15e4e6fa     802	.gitignore
100644 blob 415053bfa048ad41441ddb0c918fa32e8fef93a5     213	CONTRIBUTING.md
100644 blob 42b4a54f6f77350e0e3a7ec73b72ff44cd51ff91     959	README.md
100644 blob 04eb14ae9b3bdb3ffbbb6661df63f3c03355830f    2109	app/Console/Commands/GenerateBillOccurrences.php
100644 blob 00f998c6566e45e63a02f1799903946d0a945a02     806	app/Console/Kernel.php
100644 blob 613bcd9d935fca7b0e7451060d8dd640f77c2509    1038	app/Http/Controllers/Auth/AuthenticatedSessionController.php
100644 blob 712394a5a377259f398070884d4c15e9bd7a575c    1024	app/Http/Controllers/Auth/ConfirmablePasswordController.php
100644 blob f64fa9ba79891e709d812c99dcc4440ed237993d     630	app/Http/Controllers/Auth/EmailVerificationNotificationController.php
100644 blob ee3cb6facd7f33c1c5e2a2943915c1c1a203b1f0     564	app/Http/Controllers/Auth/EmailVerificationPromptController.php
100644 blob e8368bd22a9771696ef87574dc25914eb2c0a39d    2210	app/Http/Controllers/Auth/NewPasswordController.php
100644 blob 69164091a61710120417c27d90793a6bb2074e4d     795	app/Http/Controllers/Auth/PasswordController.php
100644 blob bf1ebfa7882b546604645fbef3a780c55f0660d7    1311	app/Http/Controllers/Auth/PasswordResetLinkController.php
100644 blob 37235fa9927a95ba11fb8e9dd174bbb35bfe901b    1963	app/Http/Controllers/Auth/RegisteredUserController.php
100644 blob 784765e3a5961b9293b74158d8c270088ef4738a     800	app/Http/Controllers/Auth/VerifyEmailController.php
100644 blob bd3e17ed1c3add3d68702e689a75dace1e0e3023     308	app/Http/Controllers/Controller.php
100644 blob 2e8760627bd26f15d9b06cf6b87a3eb8b3593062     705	app/Http/Controllers/DashboardController.php
100644 blob d02fefdf5f9eb574ae495d9ee2b5455e85542330    4723	app/Http/Controllers/FamilyBillsController.php
100644 blob ef21fa10d11da34aff610e460dbdb523628e9448    1291	app/Http/Controllers/FamilyController.php
100644 blob 97bde3e468fd84632c4a05f73fc820f7c17d7021     485	app/Http/Controllers/FamilyDashboardController.php
100644 blob fe4eca3a82bcc7efdefc7ef54137fe21822693aa    2235	app/Http/Controllers/FamilyIncomesController.php
100644 blob ec354c233b9772347d020b8e9611799a0f869bb0    5547	app/Http/Controllers/FamilyMembersController.php
100644 blob bd156504f441086e0950e17f4f33ef007d58dc49    4477	app/Http/Controllers/FamilyPlanpagActionsController.php
100644 blob b83eddb276dd328abf6850664e6c70d8f08cfc64    1006	app/Http/Controllers/FamilyPlanpagPageController.php
100644 blob 3427a887acd356384dccd154b470c55dde735628    3288	app/Http/Controllers/PlanpagController.php
100644 blob a48eb8d829dc3b348d094c108fcda9219c5c4ee7    1416	app/Http/Controllers/ProfileController.php
100644 blob efca4faddbb0f27ae3e52e13e835112e296f909c    1784	app/Http/Controllers/TaxonomyController.php
100644 blob 5bd0adae13ec6f43a2d4ab473d6b91842357cb46    1214	app/Http/Middleware/AutoActivateFamily.php
100644 blob 4c65219710a6866bdb01dfc659d9449830b59f54    1272	app/Http/Middleware/EnsureFamilyAccess.php
100644 blob 25746424580a1206e6995f034ecbf8b9cc7cd607    2233	app/Http/Requests/Auth/LoginRequest.php
100644 blob 3622a8f37c2accfa385618240df70ac74fea342a     743	app/Http/Requests/ProfileUpdateRequest.php
100644 blob aab03ec7fcea0918eacb519c57366c85716ae15d     481	app/Http/Requests/StoreBillRequest.php
100644 blob 6f1308d1566446436191eab9010ee885a49b4607    2074	app/Models/Bill.php
100644 blob 5697478045f05e0ae1577fecf8eda1a2a9934138    1083	app/Models/BillOccurrence.php
100644 blob 3695535435524cc937ab9c071793f2e569c3a988     629	app/Models/BudgetEntry.php
100644 blob 034708c0375cbc02160da41613b14e7c986a12f8    1818	app/Models/BudgetLine.php
100644 blob 91cb51708b0825907b3e8b89371ce4547b6d56e2    1052	app/Models/Family.php
100644 blob a52c0ce2c20a055f9c454deb797ee21c7c57c520     982	app/Models/FamilyMember.php
100644 blob bd678642d22da0ac9c9bfb477faabb90be0206b7     487	app/Models/Income.php
100644 blob 5da243d06484147890203933e74b6ff70fddc8ec    1103	app/Models/Scenario.php
100644 blob 0a7e1b8bb54f16dfd25e3c2f2405ac88050d219a    1582	app/Models/TaxonomyNode.php
100644 blob 6baa3966928694de19f57396816838536592bbcd    2223	app/Models/User.php
100644 blob 9a1c22d8731e407b9c90bfba819b61eac916446c     650	app/Policies/BillOccurrencePolicy.php
100644 blob 25dd7ac1532d255ad4177f7fa85981ca4eaeecc6     833	app/Policies/BillPolicy.php
100644 blob 0dda4f81a2fd97693ec2b4c3508446befe75ea01    1217	app/Policies/FamilyMemberPolicy.php
100644 blob 22df510fd159fc92eba951b079a7d2a184af8cf7    1954	app/Policies/IncomePolicy.php
100644 blob 452e6b65b7a18aa7c3aaf886fd183a002d381e34     361	app/Providers/AppServiceProvider.php
100644 blob 5ee701201188bf6a94331e8d32c3a994d854666a    6965	app/Services/BillOccurrenceGenerator.php
100644 blob fb7436eb5c4189223ec018fff1feeacfc6db3cd4    1318	app/Services/FamilyActivationService.php
100644 blob 0bfe2cf305ce72e8a4cd50e96ef5fcb9fc73e8b5     804	app/Services/PlanpagService.php
100644 blob de0d46f58d545f9ac069c08320d22d0550913986     296	app/View/Components/AppLayout.php
100644 blob d1f62539fd96b38a9db3e6979832c000fe13b15e     300	app/View/Components/GuestLayout.php
100644 blob c35e31d6a29f62921a8621944eb20ad162f5b2bb     425	artisan
100644 blob 7e3d676968bcbb7473bede820dbb23631bd513ac   14565	bin/familyfin-full.ps1
100644 blob 8cadf5f27213c8a6c43befd711be423c2d34dcda    9483	bin/familyfin-snapshot.ps1
100644 blob 1f498338475480c3960bb22c32938d2a3f509ce0    7757	bin/familyfin-snapshot.sh
100644 blob 6fdd82f1df0c35cd91dd0ddcb627024a72dc0e3b    1153	bin/snapshot.ps1
100644 blob 429a3b45dea46094d1fffd72406de2c3af9d1533     630	bootstrap/app.php
100644 blob d6b7ef32c8478a48c3994dcadc86837f4371184d      14	bootstrap/cache/.gitignore
100644 blob 38b258d1855b5e767bde3df168106f468088472f      64	bootstrap/providers.php
100644 blob 682ddb02c01914b1fd1473dd1f8a2c79b1966758    2882	composer.json
100644 blob cd70d58d56968224864d8b667300efb43e695728  311267	composer.lock
100644 blob 28be821aae5a85b26ac508ad331afed18223f849    4293	config/app.php
100644 blob 7d1eb0de5f7b4f549eb75c2db00945d89904808e    4029	config/auth.php
100644 blob b32aead257f9e0eb5fa55c7156ca2e841e76642f    3683	config/cache.php
100644 blob df933e7f173a14a97795e1f2f548b4f0edee70ef    6979	config/database.php
100644 blob 37d8fca4f6f85da3a176a3668c537bc5e7fd29a7    2532	config/filesystems.php
100644 blob 9e998a496c8641df4f3c0ecaeaa1ad167e5890c0    4327	config/logging.php
100644 blob 522b284b8f7ed47c3291b2eb6c30d6613ce16f13    3614	config/mail.php
100644 blob 79c2c0a23cd06bcb6d22ea0a2b218e22a6d51198    4199	config/queue.php
100644 blob 6a90eb8305bb7ffdf10fb55fb10e06d3c4752043    1039	config/services.php
100644 blob 5b541b75573dfdba582dc870c51a7274a7fe2a32    7848	config/session.php
100644 blob 9b19b93c9f13d72749cc3bac760a28325116f3f1      10	database/.gitignore
100644 blob e26427ccfc277a18a3da73d10baa83f3ecbf1b69    1803	database/factories/BillFactory.php
100644 blob e10e87cbd02c4efc9ad6aabd00740db70d92e969    1202	database/factories/BillOccurrenceFactory.php
100644 blob 0e3ef95db976b13c2d754ac63075912da5bc1c80     551	database/factories/BudgetEntryFactory.php
100644 blob c3d56b67603d9017ef0e4799c08b984be28790e5    1373	database/factories/BudgetLineFactory.php
100644 blob b8a74f958322a48a1c9011aeb1af110a3f976ddf     521	database/factories/FamilyFactory.php
100644 blob c4461908b16afd2d5490febcd2ff9f259c222e7e     952	database/factories/FamilyMemberFactory.php
100644 blob f56424dfd5327f194a6a3e411dd45ab5facf8161     597	database/factories/IncomeFactory.php
100644 blob 5d43807336c915ecb4ff0fb5f4d68896cae66dc1     814	database/factories/ScenarioFactory.php
100644 blob 584104c9cf7521e255fad7a01e2cec3658a4d2c4    1075	database/factories/UserFactory.php
100644 blob 05fb5d9ea95d1b527ba0e7074936553944b8d302    1473	database/migrations/0001_01_01_000000_create_users_table.php
100644 blob ed758bdf495e0b90f440881505ffc7cf0dfa3935     867	database/migrations/0001_01_01_000001_create_cache_table.php
100644 blob 425e7058fcc7c202cef39889ff4b27d2fb1f798e    1812	database/migrations/0001_01_01_000002_create_jobs_table.php
100644 blob 1e31113ceeb74fef750dc01f1f4aa8f63094275f     962	database/migrations/2026_01_23_213624_create_families_table.php
100644 blob 6f2c89dfa58cad3fece500096e921798e45dcf59    1245	database/migrations/2026_01_23_213625_create_family_members_table.php
100644 blob dcd2ae7e2474708d9884e6796fff2450ea0a15ae    2440	database/migrations/2026_01_23_221245_create_taxonomy_nodes_table.php
100644 blob 0f76f281ee9798340599d00f541db98a8f7cd412    2604	database/migrations/2026_01_23_222836_create_budget_lines_table.php
100644 blob 23d99d60b3d27495f045a3545524b4cfe17f8093    1021	database/migrations/2026_01_23_222837_create_budget_entries_table.php
100644 blob 921a6478f358564185489e2cfc2b5ed274b816df    1468	database/migrations/2026_01_23_223001_create_scenarios_table.php
100644 blob 9904b1058fc81acfbfb405394bbe3479abec68c6    3288	database/migrations/2026_01_23_224940_create_bills_table.php
100644 blob 7da856d2cfd3724c7d52752e4776479e14350860    2125	database/migrations/2026_01_23_225122_create_bill_occurrences_table.php
100644 blob 476af0805feaad4da7ddec4cb30c247410f9be09     595	database/migrations/2026_02_04_145800_create_incomes_table.php
100644 blob 875626c0461831c26d3cec1f3081255ba7c5dc52     526	database/seeders/DatabaseSeeder.php
100644 blob a3ac0624cb685cbe224755406bc8a8f9ee0bcccf     267	database/seeders/IncomeSeeder.php
100644 blob d4c9573890792cf7a479219db3bb318950f6ffd0    6229	database/seeders/TaxonomySeeder.php
100644 blob 6ec5420b491b5756ffc04685773ee76173695138     497	docs/SETUP_BREEZE.md
100644 blob 614d90a2b8c91a0328ede78d4934990d9401cf1d  152987	docs/snapshots/SNAPSHOT_FULL.md
100644 blob f642b53b8898bdfda003861170621e1a3efdaa81    5080	docs/snapshots/SNAPSHOT_LATEST.md
100644 blob 84a34298c20446cf7f5c8a2ca68ef47b3164409e  136510	package-lock.json
100644 blob 2ea7e1db406eda18cf430972ec87ac24d7d3499f     549	package.json
100644 blob d703241533c7f007d11c7f25ea7772f0155fadb8    1284	phpunit.xml
100644 blob 49c0612d5c24aa905f8b947afbf3367746452476      93	postcss.config.js
100644 blob b574a597daf309b383dc2dc2bd1e5362630e2531     740	public/.htaccess
100644 blob e69de29bb2d1d6434b8b29ae775ad8c2e48c5391       0	public/favicon.ico
100644 blob ee8f07e993802c29e166435e55e302ebfff1c12b     543	public/index.php
100644 blob eb0536286f3081c6c0646817037faf5446e3547d      24	public/robots.txt
100644 blob b5c61c956711f981a41e95f7fcf0038436cfbb22      59	resources/css/app.css
100644 blob a8093bee7686ff28db6c6f89afac6e2c4da1518c      96	resources/js/app.js
100644 blob 5f1390b015cbf1ee54f580c38fcd47a723eb81f4     127	resources/js/bootstrap.js
100644 blob 3d381860098a5895b5978fcca93ba6a358c9cfd7     886	resources/views/auth/confirm-password.blade.php
100644 blob cb32e08f3e89d73de3bea607442d0ad46a4d3346     981	resources/views/auth/forgot-password.blade.php
100644 blob 78b684f7d1d6c4a09434933dac3ef3ae652d85f3    1963	resources/views/auth/login.blade.php
100644 blob a857242c86e14410e1302e5e2071cb8c2a85b33b    2183	resources/views/auth/register.blade.php
100644 blob a6494ccaaed54768a9d2b7cb5ea78503bbe59450    1646	resources/views/auth/reset-password.blade.php
100644 blob eaf811d1b4688b825c2c2561db4f1750ea46d921    1246	resources/views/auth/verify-email.blade.php
100644 blob 46579cf07dfe96e2adee727bf7a2e04c02f0ff13    3045	resources/views/components/application-logo.blade.php
100644 blob c4bd6e23c598075e32ea2b5f3400b4828bee3329     160	resources/views/components/auth-session-status.blade.php
100644 blob d17d28898f72973bfa97ff6ddfedaf45124e9345     380	resources/views/components/danger-button.blade.php
100644 blob e0f8ce1d309aa4025aad0034ed2fb1fb593f706c     217	resources/views/components/dropdown-link.blade.php
100644 blob a46f7c83860462b20a758f026e0460bb0d1a4b11    1244	resources/views/components/dropdown.blade.php
100644 blob 9e6da217b7b9f02a0a4e65b443e21ed48e8d40b0     241	resources/views/components/input-error.blade.php
100644 blob 1cc65e21d6d4b4bd08ad65a82edbfbdf76094955     143	resources/views/components/input-label.blade.php
100644 blob 70704c1ab9d7364ad311b4f2c3dc8dc098cbfb1b    3205	resources/views/components/modal.blade.php
100644 blob 5c101a29e88fd314bb5051f04b09896bb63577b8     605	resources/views/components/nav-link.blade.php
100644 blob d71f0b6769964a104ae4b9c445a3b713b9997cf9     404	resources/views/components/primary-button.blade.php
100644 blob 43b91e7bde768fe72c99dbdc0f2e38b805b81c32     688	resources/views/components/responsive-nav-link.blade.php
100644 blob b32b69fc76586fc7bff89f3b1c7d05afdc5df2a8     393	resources/views/components/secondary-button.blade.php
100644 blob da1b12d81bc5ec6b19d854fdd400bcdb65e2170e     184	resources/views/components/text-input.blade.php
100644 blob 60cdaf93f8b5f1f287428044f3ae419afcbf9ac4    5008	resources/views/dashboard.blade.php
100644 blob 12bb5cd351e0a8b137f5372992f650628be21a8e    2416	resources/views/family/bills/create.blade.php
100644 blob 72dc584c5506be14d15e348eb781fa7229666c4f    3683	resources/views/family/bills/edit.blade.php
100644 blob e4bf9591b5a286d93846f92581a25f6c948dbbdf    6729	resources/views/family/bills/index.blade.php
100644 blob 01b8b7e2b2f4648da4e52ffb8c5b7883224213ae    1904	resources/views/family/dashboard.blade.php
100644 blob 92a17791d806f82bf4108e207666af32f703bd0b   10190	resources/views/family/incomes/index.blade.php
100644 blob 770df2a28c447084ee8a5ada264c43011d069ee5    8236	resources/views/family/members/index.blade.php
100644 blob f5261930eb17e3f56a673e7b59b03e81b2b3f736   11759	resources/views/family/planpag.blade.php
100644 blob c5ff315fe4d6267a78abcd3f46b9fea6a7482dba    1188	resources/views/layouts/app.blade.php
100644 blob 11feb470a101c9b83405bd14dbec124166120afe    1144	resources/views/layouts/guest.blade.php
100644 blob f63d5185e6a443a0fdd1bc5cf9d53a0127387ef6    8344	resources/views/layouts/navigation.blade.php
100644 blob 4d7aa2e27b19b6e68f32d180e7a78bbbd150bce1    5424	resources/views/planpag/index.blade.php
100644 blob e0e1d387e2cae39db07cfa2cba86e080e325e22e     969	resources/views/profile/edit.blade.php
100644 blob edeeb4a69bdb2497172837b92d0bb0759dc1a9a0    2140	resources/views/profile/partials/delete-user-form.blade.php
100644 blob eaca1accca55cb91af51fa37b1f78ee568cfd0b8    2118	resources/views/profile/partials/update-password-form.blade.php
100644 blob 5ae3d35d053b0fa154b4a594ea873dd9b52d04f9    2674	resources/views/profile/partials/update-profile-information-form.blade.php
100644 blob b7355d72a12820cc4663a607ebf567d4db057704   82568	resources/views/welcome.blade.php
100644 blob 3926ecf72a8b0ceb1d796215be602d6b6accf846    2360	routes/auth.php
100644 blob 3c9adf1af8430da566d123514630bcc30c9c1345     210	routes/console.php
100644 blob 49e4e139d337a96b0b2b66a22a819eddd15c2c43    6158	routes/web.php
100644 blob fedb287fece8049b6bd243804b133e3af7a43f4c      33	storage/app/.gitignore
100644 blob d6b7ef32c8478a48c3994dcadc86837f4371184d      14	storage/app/private/.gitignore
100644 blob d6b7ef32c8478a48c3994dcadc86837f4371184d      14	storage/app/public/.gitignore
100644 blob 05c4471f2b53fc17d3cac9d3d252755a35479f7c     119	storage/framework/.gitignore
100644 blob d6b7ef32c8478a48c3994dcadc86837f4371184d      14	storage/logs/.gitignore
100644 blob c29eb1a15ba81609f29337f8db51d91712409341     541	tailwind.config.js
100644 blob afcb2a7523dbe0470949beb1f4a13083db5f6f1b    1881	tests/Feature/ActiveFamilyFlowTest.php
100644 blob 13dcb7ce7eb6c9d3a75bc95ddfdcd024337f1418    1270	tests/Feature/Auth/AuthenticationTest.php
100644 blob 705570b43f3a048623759a159020d7ee0739cc57    1645	tests/Feature/Auth/EmailVerificationTest.php
100644 blob ff85721e25d7f6c662352ffb861d52798bbf27f2    1082	tests/Feature/Auth/PasswordConfirmationTest.php
100644 blob aa50350588345237d55315d5e59f8fe4fd93ad6f    1992	tests/Feature/Auth/PasswordResetTest.php
100644 blob ca28c6c6eb4687e4207b83c9d2f871fe7dae1dd2    1409	tests/Feature/Auth/PasswordUpdateTest.php
100644 blob 1489d0e0f1d7b358509b0226a279d62081c11410     751	tests/Feature/Auth/RegistrationTest.php
100644 blob 248ddec4bed17253df1f7510b068b327e356c41c    3437	tests/Feature/BillOccurrenceGeneratorTest.php
100644 blob d1035540053bfc7c7523754538c49ac23013be02    1462	tests/Feature/BillPaymentFlowTest.php
100644 blob 7d56bc0b880061aa93c8baeb6b8242a492b71980    5825	tests/Feature/BillsUiFlowTest.php
100644 blob f0a34d7892f60944fc03ecb99fed63b370a67941    2350	tests/Feature/BudgetBasicsTest.php
100644 blob 3c0915da9a4d4246cd02c2ded0c8c89fc7171f2a    1419	tests/Feature/EnterActivatesFamilyTest.php
100644 blob 8364a84e2b7eea9f007e99a5d3333273fe30bf8a     359	tests/Feature/ExampleTest.php
100644 blob 022f217de6e78e911a2b06192a853434a3d3d1ad    1229	tests/Feature/FamilyAccessMiddlewareTest.php
100644 blob 9c7ce9789e15ea2a6207fe5aff6cb48c6475650c    4340	tests/Feature/FamilyMembersFlowTest.php
100644 blob 4f3b4d2e0622de614dce17ca7ef23436f471ee21    4085	tests/Feature/IncomeFlowTest.php
100644 blob 63d512c75852acf8ad579e62495a7783fd3c63dd    2727	tests/Feature/PlanpagEndpointTest.php
100644 blob ce1677527f11a6ed939faf2373fb18fb3911667c   13651	tests/Feature/PlanpagUiPageTest.php
100644 blob 252fdcc525a1d0a0c52fe12ffca7d89fc87292ea    2501	tests/Feature/ProfileTest.php
100644 blob 71878d5320d190e67bdd6554c24af61564b96c7e    2198	tests/Feature/ScopedRoutesAutoActivateFamilyTest.php
100644 blob 1c59233da2d805b40e82fdb7a74095d13a985db3    1540	tests/Feature/TaxonomyEndpointTest.php
100644 blob d1c08541566656972fd5af1767b87e508b9f46a3    1355	tests/Feature/TenancyIsolationTest.php
100644 blob fe1ffc2ff1abc1c23522418994879623c5647859     142	tests/TestCase.php
100644 blob 5773b0ceb771e176520d5a9c1efe5e918878318d     243	tests/Unit/ExampleTest.php
100644 blob 421b5695627db43c022947cfc7c0ecce6b9689be     263	vite.config.js
```

### Shortlog (authors)

```
    52	RanielMattos
```

### Full history (reverse, detailed)

- From first commit to current, with author + date + subject

```
bb9dcf9 | 2026-01-23 21:28:27 -0300 | RanielMattos | 
chore: bootstrap laravel app

f5d3c6c | 2026-01-23 22:11:44 -0300 | RanielMattos | 
feat: add family tenancy core

e68a8a2 | 2026-01-23 22:27:28 -0300 | RanielMattos | 
feat: add taxonomy seed and endpoint

7193e81 | 2026-01-23 22:48:14 -0300 | RanielMattos | 
feat: add scenarios and budget core

6b9da56 | 2026-01-23 23:11:03 -0300 | RanielMattos | 
feat: add planpag core and endpoint

dbbacb6 | 2026-01-23 23:17:29 -0300 | RanielMattos | 
chore: add root healthcheck route

0d89ba0 | 2026-01-23 23:35:30 -0300 | RanielMattos | 
docs: add project README

6c99ef4 | 2026-01-24 07:53:06 -0300 | RanielMattos | 
chore: normalize line endings

9ead7fc | 2026-01-24 07:56:13 -0300 | RanielMattos | 
ci: add github actions workflow

0b88f44 | 2026-01-24 08:28:55 -0300 | RanielMattos | 
docs: improve README

fff2609 | 2026-01-24 13:59:44 -0300 | RanielMattos | 
docs: add ci badge

124bbcb | 2026-01-24 15:23:11 -0300 | RanielMattos | 
docs: add contributing guide (#1)

499369a | 2026-01-25 11:12:44 -0300 | RanielMattos | 
Feat/auth UI skeleton (#3)

9d785f8 | 2026-01-25 12:48:53 -0300 | RanielMattos | 
docs: add breeze setup guide (#4)

b6aa7cc | 2026-01-25 13:05:13 -0300 | RanielMattos | 
test: try push directly to main (#5)

19f6a39 | 2026-01-25 13:56:27 -0300 | RanielMattos | 
Revert "test: try push directly to main (#5)" (#6)

77e5a22 | 2026-01-25 14:46:38 -0300 | RanielMattos | 
fix: normalize family member role to lowercase (#7)

b9d899c | 2026-01-25 14:59:14 -0300 | RanielMattos | 
feat: create family on registration (#8)

96cf942 | 2026-01-25 16:34:01 -0300 | RanielMattos | 
feat(ui): family dashboard + public endpoints (#9)

a7eb52b | 2026-01-25 18:02:13 -0300 | RanielMattos | 
feat(tenancy): active family redirect + activation (#10)

74f4dbe | 2026-01-25 18:10:10 -0300 | RanielMattos | 
feat(tenancy): auto-activate family on enter (#12)

fca0558 | 2026-01-25 18:30:29 -0300 | RanielMattos | 
refactor(tenancy): centralize family activation (#13)

8bc65b8 | 2026-01-25 18:50:39 -0300 | RanielMattos | 
feat(tenancy): auto-activate family on scoped routes (#14)

4488523 | 2026-01-26 12:22:51 -0300 | RanielMattos | 
feat(planpag): add family scoped UI page (#15)

21e9275 | 2026-01-26 19:42:29 -0300 | RanielMattos | 
feat(bills): add family-scoped bills UI (#16)

dd8f5e4 | 2026-01-26 19:48:49 -0300 | RanielMattos | 
fix(bills): redirect to index after create (#17)

1367eda | 2026-01-26 20:02:13 -0300 | RanielMattos | 
feat(bills): add edit and delete flows (#18)

e7aad12 | 2026-01-26 20:25:29 -0300 | RanielMattos | 
fix(bills): prevent deleting bills with occurrences (#19)

0042b1e | 2026-01-26 20:40:26 -0300 | RanielMattos | 
feat(bills): toggle active status (#20)

5163e23 | 2026-01-26 21:10:10 -0300 | RanielMattos | 
feat(planpag): add occurrence generator and command (#21)

00bc96a | 2026-01-26 22:10:31 -0300 | RanielMattos | 
feat(planpag): mark occurrence as paid (#22)

0baedee | 2026-01-27 10:53:17 -0300 | RanielMattos | 
feat(planpag): unmark occurrence as paid (#23)

8ea343e | 2026-01-27 14:02:55 -0300 | RanielMattos | 
feat(planpag): toggle paid action on UI (#24)

588c073 | 2026-01-27 14:30:09 -0300 | RanielMattos | 
test(planpag): cover unmark paid flow (#25)

ae54ec1 | 2026-01-27 20:40:24 -0300 | RanielMattos | 
feat(planpag): allow custom paid amount on mark paid (#26)

dea1acc | 2026-01-27 21:26:23 -0300 | RanielMattos | 
chore(git): protect main with local hooks (#27)

4e52acd | 2026-01-27 22:08:56 -0300 | RanielMattos | 
chore(docs): add snapshot system (latest + full) (#28)

a981ae8 | 2026-01-29 10:56:40 -0300 | RanielMattos | 
chore(docs): harden full snapshot script (ascii + robust config:show) (#29)

a537808 | 2026-02-04 20:50:16 -0300 | RanielMattos | 
Add incomes feature (tenancy scoped) + IncomeFlowTest (#30)

53bafd8 | 2026-02-04 21:23:29 -0300 | RanielMattos | 
Track snapshot docs (LATEST + FULL) (#31)

c11536f | 2026-02-04 21:27:11 -0300 | RanielMattos | 
Update snapshots (#32)

23db586 | 2026-02-08 15:39:56 -0300 | RanielMattos | 
Add Receitas link to family navigation (#33)

aafacd8 | 2026-02-08 15:52:34 -0300 | RanielMattos | 
Improve incomes UI (table, edit, delete, totals) (#34)

b029d8d | 2026-02-11 14:38:46 -0300 | RanielMattos | 
Add IncomePolicy (tenancy) + auto snapshot post-commit hook (#35)

11fd65d | 2026-02-11 14:41:39 -0300 | RanielMattos | 
Fix/incomes policy (#37)

03b617a | 2026-02-11 17:21:12 -0300 | RanielMattos | 
Fix incomes tenancy: scopeBindings + harden IncomeFlowTest (#38)

554038a | 2026-02-13 08:32:36 -0300 | RanielMattos | 
Update snapshots (LATEST + FULL) (#39)

0f6123b | 2026-02-13 11:57:39 -0300 | RanielMattos | 
Add family members management (roles + UI) (#40)

47bf31e | 2026-02-13 12:03:07 -0300 | RanielMattos | 
Update snapshots (LATEST + FULL) (#41)

2303869 | 2026-02-13 16:27:40 -0300 | RanielMattos | 
RBAC: add family role helpers and authorize incomes via policies (#42)

40e2265 | 2026-02-13 16:53:51 -0300 | RanielMattos | 
Feat/rbac family members policy (#43)

d8e4164 | 2026-02-13 18:35:31 -0300 | RanielMattos |  (HEAD -> main, origin/main, origin/HEAD)
RBAC: authorize bills and planpag via policies (#44)
```

## Hooks (local main guard)

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


### PowerShell / OS

```
System.Collections.Hashtable
```
```

```

### PHP version

```
PHP 8.2.12 (cli) (built: Oct 24 2023 21:15:15) (ZTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.2.12, Copyright (c) Zend Technologies
```

### PHP ini + modules

```
Configuration File (php.ini) Path: 
Loaded Configuration File:         C:\.xampp\php\php.ini
Scan for additional .ini files in: (none)
Additional .ini files parsed:      (none)
```
```
[PHP Modules]
bcmath
bz2
calendar
Core
ctype
curl
date
dom
exif
fileinfo
filter
ftp
gettext
hash
iconv
json
libxml
mbstring
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
pdo_pgsql
pdo_sqlite
pgsql
Phar
random
readline
Reflection
session
SimpleXML
SPL
sqlite3
standard
tokenizer
xml
xmlreader
xmlwriter
xsl
zip
zlib

[Zend Modules]

```

### Composer

```
[32mComposer[39m version [33m2.8.12[39m 2025-09-19 13:41:59
[32mPHP[39m version [33m8.2.12[39m (C:\.xampp\php\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.
```
```
[32m./composer.json is valid[39m
```

### Composer inventory (packages)

```
brick/math                         0.14.1  Arbitrary-precision arithmetic library
carbonphp/carbon-doctrine-types    3.2.0   Types to use Carbon in Doctrine
dflydev/dot-access-data            3.0.3   Given a deep data structure, access data by dot notation.
doctrine/inflector                 2.1.0   PHP Doctrine Inflector is a small library that can perform string manipulations with regard to upper/lowercase and s...
doctrine/lexer                     3.0.1   PHP Doctrine Lexer parser library that can be used in Top-Down, Recursive Descent Parsers.
dragonmantank/cron-expression      3.6.0   CRON for PHP: Calculate the next or previous run date and determine if a CRON expression is due
egulias/email-validator            4.0.4   A library for validating emails against several RFCs
fakerphp/faker                     1.24.1  Faker is a PHP library that generates fake data for you.
filp/whoops                        2.18.4  php error handling for cool kids
fruitcake/php-cors                 1.4.0   Cross-origin resource sharing library for the Symfony HttpFoundation
graham-campbell/result-type        1.1.4   An Implementation Of The Result Type
guzzlehttp/guzzle                  7.10.0  Guzzle is a PHP HTTP client library
guzzlehttp/promises                2.3.0   Guzzle promises library
guzzlehttp/psr7                    2.8.0   PSR-7 message implementation that also provides common utility methods
guzzlehttp/uri-template            1.0.5   A polyfill class for uri_template of PHP
hamcrest/hamcrest-php              2.1.1   This is the PHP port of Hamcrest Matchers
laravel/breeze                     2.3.8   Minimal Laravel authentication scaffolding with Blade and Tailwind.
laravel/framework                  12.48.1 The Laravel Framework.
laravel/pail                       1.2.4   Easily delve into your Laravel application's log files directly from the command line.
laravel/pint                       1.27.0  An opinionated code formatter for PHP.
laravel/prompts                    0.3.10  Add beautiful and user-friendly forms to your command-line applications.
laravel/sail                       1.52.0  Docker files for running a basic Laravel application.
laravel/serializable-closure       2.0.8   Laravel Serializable Closure provides an easy and secure way to serialize closures in PHP.
laravel/tinker                     2.11.0  Powerful REPL for the Laravel framework.
league/commonmark                  2.8.0   Highly-extensible PHP Markdown parser which fully supports the CommonMark spec and GitHub-Flavored Markdown (GFM)
league/config                      1.2.0   Define configuration arrays with strict schemas and access values with dot notation
league/flysystem                   3.31.0  File storage abstraction for PHP
league/flysystem-local             3.31.0  Local filesystem adapter for Flysystem.
league/mime-type-detection         1.16.0  Mime-type detection for Flysystem
league/uri                         7.8.0   URI manipulation library
league/uri-interfaces              7.8.0   Common tools for parsing and resolving RFC3987/RFC3986 URI
mockery/mockery                    1.6.12  Mockery is a simple yet flexible PHP mock object framework
monolog/monolog                    3.10.0  Sends your logs to files, sockets, inboxes, databases and various web services
myclabs/deep-copy                  1.13.4  Create deep copies (clones) of your objects
nesbot/carbon                      3.11.0  An API extension for DateTime that supports 281 different languages.
nette/schema                       1.3.3    Nette Schema: validating data structures against a given Schema.
nette/utils                        4.1.1     Nette Utils: lightweight utilities for string & array manipulation, image handling, safe JSON encoding/decodin...
nikic/php-parser                   5.7.0   A PHP parser written in PHP
nunomaduro/collision               8.8.3   Cli error handling for console/command-line PHP applications.
nunomaduro/termwind                2.3.3   Its like Tailwind CSS, but for the console.
phar-io/manifest                   2.0.4   Component for reading phar.io manifest information from a PHP Archive (PHAR)
phar-io/version                    3.2.1   Library for handling version information and constraints
phpoption/phpoption                1.9.5   Option Type for PHP
phpunit/php-code-coverage          11.0.12 Library that provides collection, processing, and rendering functionality for PHP code coverage information.
phpunit/php-file-iterator          5.1.0   FilterIterator implementation that filters files based on a list of suffixes.
phpunit/php-invoker                5.0.1   Invoke callables with a timeout
phpunit/php-text-template          4.0.1   Simple template engine.
phpunit/php-timer                  7.0.1   Utility class for timing
phpunit/phpunit                    11.5.48 The PHP Unit Testing framework.
psr/clock                          1.0.0   Common interface for reading the clock.
psr/container                      2.0.2   Common Container Interface (PHP FIG PSR-11)
psr/event-dispatcher               1.0.0   Standard interfaces for event handling.
psr/http-client                    1.0.3   Common interface for HTTP clients
psr/http-factory                   1.1.0   PSR-17: Common interfaces for PSR-7 HTTP message factories
psr/http-message                   2.0     Common interface for HTTP messages
psr/log                            3.0.2   Common interface for logging libraries
psr/simple-cache                   3.0.0   Common interfaces for simple caching
psy/psysh                          0.12.18 An interactive shell for modern PHP.
ralouphie/getallheaders            3.0.3   A polyfill for getallheaders.
ramsey/collection                  2.1.1   A PHP library for representing and manipulating collections.
ramsey/uuid                        4.9.2   A PHP library for generating and working with universally unique identifiers (UUIDs).
sebastian/cli-parser               3.0.2   Library for parsing CLI options
sebastian/code-unit                3.0.3   Collection of value objects that represent the PHP code units
sebastian/code-unit-reverse-lookup 4.0.1   Looks up which function or method a line of code belongs to
sebastian/comparator               6.3.2   Provides the functionality to compare PHP values for equality
sebastian/complexity               4.0.1   Library for calculating the complexity of PHP code units
sebastian/diff                     6.0.2   Diff implementation
sebastian/environment              7.2.1   Provides functionality to handle HHVM/PHP environments
sebastian/exporter                 6.3.2   Provides the functionality to export PHP variables for visualization
sebastian/global-state             7.0.2   Snapshotting of global state
sebastian/lines-of-code            3.0.1   Library for counting the lines of code in PHP source code
sebastian/object-enumerator        6.0.1   Traverses array structures and object graphs to enumerate all referenced objects
sebastian/object-reflector         4.0.1   Allows reflection of object attributes, including inherited and non-public ones
sebastian/recursion-context        6.0.3   Provides functionality to recursively process PHP variables
sebastian/type                     5.1.3   Collection of value objects that represent the types of the PHP type system
sebastian/version                  5.0.2   Library that helps with managing the version number of Git-hosted PHP projects
staabm/side-effects-detector       1.0.5   A static analysis tool to detect side effects in PHP code
symfony/clock                      7.4.0   Decouples applications from the system clock
symfony/console                    7.4.3   Eases the creation of beautiful and testable command line interfaces
symfony/css-selector               7.4.0   Converts CSS selectors to XPath expressions
symfony/deprecation-contracts      3.6.0   A generic function and convention to trigger deprecation notices
symfony/error-handler              7.4.0   Provides tools to manage errors and ease debugging PHP code
symfony/event-dispatcher           7.4.0   Provides tools that allow your application components to communicate with each other by dispatching events and liste...
symfony/event-dispatcher-contracts 3.6.0   Generic abstractions related to dispatching event
symfony/finder                     7.4.3   Finds files and directories via an intuitive fluent interface
symfony/http-foundation            7.4.3   Defines an object-oriented layer for the HTTP specification
symfony/http-kernel                7.4.3   Provides a structured process for converting a Request into a Response
symfony/mailer                     7.4.3   Helps sending emails
symfony/mime                       7.4.0   Allows manipulating MIME messages
symfony/polyfill-ctype             1.33.0  Symfony polyfill for ctype functions
symfony/polyfill-intl-grapheme     1.33.0  Symfony polyfill for intl's grapheme_* functions
symfony/polyfill-intl-idn          1.33.0  Symfony polyfill for intl's idn_to_ascii and idn_to_utf8 functions
symfony/polyfill-intl-normalizer   1.33.0  Symfony polyfill for intl's Normalizer class and related functions
symfony/polyfill-mbstring          1.33.0  Symfony polyfill for the Mbstring extension
symfony/polyfill-php80             1.33.0  Symfony polyfill backporting some PHP 8.0+ features to lower PHP versions
symfony/polyfill-php83             1.33.0  Symfony polyfill backporting some PHP 8.3+ features to lower PHP versions
symfony/polyfill-php84             1.33.0  Symfony polyfill backporting some PHP 8.4+ features to lower PHP versions
symfony/polyfill-php85             1.33.0  Symfony polyfill backporting some PHP 8.5+ features to lower PHP versions
symfony/polyfill-uuid              1.33.0  Symfony polyfill for uuid functions
symfony/process                    7.4.3   Executes commands in sub-processes
symfony/routing                    7.4.3   Maps an HTTP request to a set of configuration variables
symfony/service-contracts          3.6.1   Generic abstractions related to writing services
symfony/string                     7.4.0   Provides an object-oriented API to strings and deals with bytes, UTF-8 code points and grapheme clusters in a unifie...
symfony/translation                7.4.3   Provides tools to internationalize your application
symfony/translation-contracts      3.6.1   Generic abstractions related to translation
symfony/uid                        7.4.0   Provides an object-oriented API to generate and represent UIDs
symfony/var-dumper                 7.4.3   Provides mechanisms for walking through any arbitrary PHP variable
symfony/yaml                       7.4.1   Loads and dumps YAML files
theseer/tokenizer                  1.3.1   A small library for converting tokenized PHP source code into XML and potentially other formats
tijsverkoyen/css-to-inline-styles  2.4.0   CssToInlineStyles is a class that enables you to convert HTML-pages/files into HTML-pages/files with inline styles. ...
vlucas/phpdotenv                   5.6.3   Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
voku/portable-ascii                2.0.3   Portable ASCII library - performance optimized (ascii) string functions for php.
```

### Composer inventory (dev packages)

```
fakerphp/faker       1.24.1  Faker is a PHP library that generates fake data for you.
laravel/breeze       2.3.8   Minimal Laravel authentication scaffolding with Blade and Tailwind.
laravel/framework    12.48.1 The Laravel Framework.
laravel/pail         1.2.4   Easily delve into your Laravel application's log files directly from the command line.
laravel/pint         1.27.0  An opinionated code formatter for PHP.
laravel/sail         1.52.0  Docker files for running a basic Laravel application.
laravel/tinker       2.11.0  Powerful REPL for the Laravel framework.
mockery/mockery      1.6.12  Mockery is a simple yet flexible PHP mock object framework
nunomaduro/collision 8.8.3   Cli error handling for console/command-line PHP applications.
phpunit/phpunit      11.5.48 The PHP Unit Testing framework.
```

### Node / npm

```
v22.20.0
```
```
10.9.3
```

### package.json fingerprint

- `package.json` SHA1: `e6ab62dde56dae91da4017e992b4ce96ba1c611d`
- `package-lock.json` SHA1: `11ffd6ecfbc6ad65fb883b1473360b19e2a7e0a0`
- `pnpm-lock.yaml` SHA1: (missing)
- `yarn.lock` SHA1: (missing)

### npm ls (depth=0)

```
familyfin@ C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin
OK @tailwindcss/forms@0.5.11
OK @tailwindcss/vite@4.1.18
OK alpinejs@3.15.4
OK autoprefixer@10.4.23
OK axios@1.13.2
OK concurrently@9.2.1
OK laravel-vite-plugin@2.1.0
OK postcss@8.5.6
OK tailwindcss@3.4.19
OK vite@7.3.1

```

## Dependency lockfiles (fingerprints)

- `composer.json` SHA1: `c343d7eec85d7a2908b76a62bf4a7e336087949d`
- `composer.lock` SHA1: `ca148aab4aa96497e5c2d91468cc0e44f968ed1f`
- `package.json` SHA1: `e6ab62dde56dae91da4017e992b4ce96ba1c611d`
- `package-lock.json` SHA1: `11ffd6ecfbc6ad65fb883b1473360b19e2a7e0a0`
- `pnpm-lock.yaml` SHA1: (missing)
- `yarn.lock` SHA1: (missing)

## Environment (masked)

- .env: present

### .env (FULL, masked)

```
APP_NAME=***REDACTED***
APP_ENV=***REDACTED***
APP_KEY=***REDACTED***
APP_DEBUG=***REDACTED***
APP_URL=***REDACTED***

APP_LOCALE=***REDACTED***
APP_FALLBACK_LOCALE=***REDACTED***
APP_FAKER_LOCALE=***REDACTED***

APP_MAINTENANCE_DRIVER=***REDACTED***
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=***REDACTED***

LOG_CHANNEL=***REDACTED***
LOG_STACK=***REDACTED***
LOG_DEPRECATIONS_CHANNEL=***REDACTED***
LOG_LEVEL=***REDACTED***

DB_CONNECTION=***REDACTED***
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=***REDACTED***
SESSION_LIFETIME=***REDACTED***
SESSION_ENCRYPT=***REDACTED***
SESSION_PATH=***REDACTED***
SESSION_DOMAIN=***REDACTED***

BROADCAST_CONNECTION=***REDACTED***
FILESYSTEM_DISK=***REDACTED***
QUEUE_CONNECTION=***REDACTED***

CACHE_STORE=***REDACTED***
# CACHE_PREFIX=

MEMCACHED_HOST=***REDACTED***

REDIS_CLIENT=***REDACTED***
REDIS_HOST=***REDACTED***
REDIS_PASSWORD=***REDACTED***
REDIS_PORT=***REDACTED***

MAIL_MAILER=***REDACTED***
MAIL_SCHEME=***REDACTED***
MAIL_HOST=***REDACTED***
MAIL_PORT=***REDACTED***
MAIL_USERNAME=***REDACTED***
MAIL_PASSWORD=***REDACTED***
MAIL_FROM_ADDRESS=***REDACTED***
MAIL_FROM_NAME=***REDACTED***

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=***REDACTED***
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=***REDACTED***

VITE_APP_NAME=***REDACTED***
```

- .env.example: present

### .env.example (masked)

```
APP_NAME=***REDACTED***
APP_ENV=***REDACTED***
APP_KEY=
APP_DEBUG=***REDACTED***
APP_URL=***REDACTED***

APP_LOCALE=***REDACTED***
APP_FALLBACK_LOCALE=***REDACTED***
APP_FAKER_LOCALE=***REDACTED***

APP_MAINTENANCE_DRIVER=***REDACTED***
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=***REDACTED***

LOG_CHANNEL=***REDACTED***
LOG_STACK=***REDACTED***
LOG_DEPRECATIONS_CHANNEL=***REDACTED***
LOG_LEVEL=***REDACTED***

DB_CONNECTION=***REDACTED***
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=***REDACTED***
SESSION_LIFETIME=***REDACTED***
SESSION_ENCRYPT=***REDACTED***
SESSION_PATH=***REDACTED***
SESSION_DOMAIN=***REDACTED***

BROADCAST_CONNECTION=***REDACTED***
FILESYSTEM_DISK=***REDACTED***
QUEUE_CONNECTION=***REDACTED***

CACHE_STORE=***REDACTED***
# CACHE_PREFIX=

MEMCACHED_HOST=***REDACTED***

REDIS_CLIENT=***REDACTED***
REDIS_HOST=***REDACTED***
REDIS_PASSWORD=***REDACTED***
REDIS_PORT=***REDACTED***

MAIL_MAILER=***REDACTED***
MAIL_SCHEME=***REDACTED***
MAIL_HOST=***REDACTED***
MAIL_PORT=***REDACTED***
MAIL_USERNAME=***REDACTED***
MAIL_PASSWORD=***REDACTED***
MAIL_FROM_ADDRESS=***REDACTED***
MAIL_FROM_NAME=***REDACTED***

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=***REDACTED***
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=***REDACTED***

VITE_APP_NAME=***REDACTED***
```

## Laravel / Artisan


### Artisan version

```
Laravel Framework 12.48.1
```

### artisan about

```

  Environment ......................................................................................................................................  
  Application Name ......................................................................................................................... Laravel  
  Laravel Version .......................................................................................................................... 12.48.1  
  PHP Version ............................................................................................................................... 8.2.12  
  Composer Version .......................................................................................................................... 2.8.12  
  Environment ................................................................................................................................ local  
  Debug Mode ............................................................................................................................... ENABLED  
  URL .................................................................................................................................... localhost  
  Maintenance Mode ............................................................................................................................. OFF  
  Timezone ..................................................................................................................................... UTC  
  Locale ........................................................................................................................................ en  

  Cache ............................................................................................................................................  
  Config ................................................................................................................................ NOT CACHED  
  Events ................................................................................................................................ NOT CACHED  
  Routes ................................................................................................................................ NOT CACHED  
  Views ..................................................................................................................................... CACHED  

  Drivers ..........................................................................................................................................  
  Broadcasting ................................................................................................................................. log  
  Cache ................................................................................................................................... database  
  Database .................................................................................................................................. sqlite  
  Logs .............................................................................................................................. stack / single  
  Mail ......................................................................................................................................... log  
  Queue ................................................................................................................................... database  
***REDACTED_LINE***

  Storage ..........................................................................................................................................  
  C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\public\storage ................................................................ LINKED  

```

### artisan env

```

   INFO  The application environment is [local].  

```

### artisan config:show app (redacted)

```

  app ..............................................................................................................................................  
  name ..................................................................................................................................... Laravel  
  env ........................................................................................................................................ local  
  debug ....................................................................................................................................... true  
  url ............................................................................................................................. http://localhost  
  frontend_url ............................................................................................................... http://localhost:3000  
  asset_url ................................................................................................................................... null  
  timezone ..................................................................................................................................... UTC  
  locale ........................................................................................................................................ en  
  fallback_locale ............................................................................................................................... en  
  faker_locale ............................................................................................................................... en_US  
  cipher ............................................................................................................................... AES-256-CBC  
  key .......................................................................................... base64: ***REDACTED***
  previous_keys ................................................................................................................................. []  
  maintenance  driver ........................................................................................................................ file  
  maintenance  store ..................................................................................................................... database  
  providers  0 ................................................................................................ Illuminate\Auth\AuthServiceProvider  
  providers  1 ................................................................................... Illuminate\Broadcasting\BroadcastServiceProvider  
  providers  2 .................................................................................................. Illuminate\Bus\BusServiceProvider  
  providers  3 .............................................................................................. Illuminate\Cache\CacheServiceProvider  
  providers  4 ...................................................................... Illuminate\Foundation\Providers\ConsoleSupportServiceProvider  
  providers  5 .................................................................................. Illuminate\Concurrency\ConcurrencyServiceProvider  
***REDACTED_LINE***
  providers  7 ........................................................................................ Illuminate\Database\DatabaseServiceProvider  
  providers  8 .................................................................................... Illuminate\Encryption\EncryptionServiceProvider  
  providers  9 .................................................................................... Illuminate\Filesystem\FilesystemServiceProvider  
  providers  10 ......................................................................... Illuminate\Foundation\Providers\FoundationServiceProvider  
  providers  11 ............................................................................................ Illuminate\Hashing\HashServiceProvider  
  providers  12 ............................................................................................... Illuminate\Mail\MailServiceProvider  
  providers  13 .............................................................................. Illuminate\Notifications\NotificationServiceProvider  
  providers  14 ................................................................................... Illuminate\Pagination\PaginationServiceProvider  
  providers  15 ............................................................................ Illuminate\Auth\Passwords\PasswordResetServiceProvider  
  providers  16 ....................................................................................... Illuminate\Pipeline\PipelineServiceProvider  
  providers  17 ............................................................................................. Illuminate\Queue\QueueServiceProvider  
  providers  18 ............................................................................................. Illuminate\Redis\RedisServiceProvider  
***REDACTED_LINE***
  providers  20 ................................................................................. Illuminate\Translation\TranslationServiceProvider  
  providers  21 ................................................................................... Illuminate\Validation\ValidationServiceProvider  
  providers  22 ............................................................................................... Illuminate\View\ViewServiceProvider  
  providers  23 .................................................................................................. App\Providers\AppServiceProvider  
  aliases  App ..................................................................................................... Illuminate\Support\Facades\App  
  aliases  Arr ............................................................................................................. Illuminate\Support\Arr  
  aliases  Artisan ............................................................................................. Illuminate\Support\Facades\Artisan  
  aliases  Auth ................................................................................................... Illuminate\Support\Facades\Auth  
  aliases  Benchmark ................................................................................................. Illuminate\Support\Benchmark  
  aliases  Blade ................................................................................................. Illuminate\Support\Facades\Blade  
  aliases  Broadcast ......................................................................................... Illuminate\Support\Facades\Broadcast  
  aliases  Bus ..................................................................................................... Illuminate\Support\Facades\Bus  
  aliases  Cache ................................................................................................. Illuminate\Support\Facades\Cache  
  aliases  Concurrency ..................................................................................... Illuminate\Support\Facades\Concurrency  
  aliases  Config ............................................................................................... Illuminate\Support\Facades\Config  
  aliases  Context ............................................................................................. Illuminate\Support\Facades\Context  
***REDACTED_LINE***
  aliases  Crypt ................................................................................................. Illuminate\Support\Facades\Crypt  
  aliases  Date ................................................................................................... Illuminate\Support\Facades\Date  
  aliases  DB ....................................................................................................... Illuminate\Support\Facades\DB  
  aliases  Eloquent ............................................................................................ Illuminate\Database\Eloquent\Model  
  aliases  Event ................................................................................................. Illuminate\Support\Facades\Event  
  aliases  File ................................................................................................... Illuminate\Support\Facades\File  
  aliases  Gate ................................................................................................... Illuminate\Support\Facades\Gate  
  aliases  Hash ................................................................................................... Illuminate\Support\Facades\Hash  
  aliases  Http ................................................................................................... Illuminate\Support\Facades\Http  
  aliases  Js ............................................................................................................... Illuminate\Support\Js  
  aliases  Lang ................................................................................................... Illuminate\Support\Facades\Lang  
  aliases  Log ..................................................................................................... Illuminate\Support\Facades\Log  
  aliases  Mail ................................................................................................... Illuminate\Support\Facades\Mail  
  aliases  Notification ................................................................................... Illuminate\Support\Facades\Notification  
  aliases  Number ....................................................................................................... Illuminate\Support\Number  
***REDACTED_LINE***
  aliases  Process ............................................................................................. Illuminate\Support\Facades\Process  
  aliases  Queue ................................................................................................. Illuminate\Support\Facades\Queue  
  aliases  RateLimiter ..................................................................................... Illuminate\Support\Facades\RateLimiter  
  aliases  Redirect ........................................................................................... Illuminate\Support\Facades\Redirect  
  aliases  Request ............................................................................................. Illuminate\Support\Facades\Request  
  aliases  Response ........................................................................................... Illuminate\Support\Facades\Response  
  aliases  Route ................................................................................................. Illuminate\Support\Facades\Route  
  aliases  Schedule ........................................................................................... Illuminate\Support\Facades\Schedule  
  aliases  Schema ............................................................................................... Illuminate\Support\Facades\Schema  
***REDACTED_LINE***
  aliases  Storage ............................................................................................. Illuminate\Support\Facades\Storage  
  aliases  Str ............................................................................................................. Illuminate\Support\Str  
  aliases  Uri ............................................................................................................. Illuminate\Support\Uri  
  aliases  URL ..................................................................................................... Illuminate\Support\Facades\URL  
  aliases  Validator ......................................................................................... Illuminate\Support\Facades\Validator  
  aliases  View ................................................................................................... Illuminate\Support\Facades\View  
  aliases  Vite ................................................................................................... Illuminate\Support\Facades\Vite  

```

### artisan config:show auth (redacted)

```

  auth .............................................................................................................................................  
  defaults  guard ............................................................................................................................. web  
  defaults  passwords ....................................................................................................................... users  
***REDACTED_LINE***
  guards  web  provider .................................................................................................................... users  
  providers  users  driver .............................................................................................................. eloquent  
  providers  users  model ........................................................................................................ App\Models\User  
  passwords  users  provider ............................................................................................................... users  
  passwords  users  table .................................................................................................. password_reset_tokens  
  passwords  users  expire .................................................................................................................... 60  
  passwords  users  throttle .................................................................................................................. 60  
  password_timeout ........................................................................................................................... 10800  

```

### artisan config:show cache (redacted)

```

  cache ............................................................................................................................................  
  default ................................................................................................................................. database  
  stores  array  driver .................................................................................................................... array  
  stores  array  serialize ................................................................................................................. false  
***REDACTED_LINE***
***REDACTED_LINE***
  stores  database  driver .............................................................................................................. database  
  stores  database  connection .............................................................................................................. null  
  stores  database  table .................................................................................................................. cache  
  stores  database  lock_connection ......................................................................................................... null  
  stores  database  lock_table .............................................................................................................. null  
  stores  file  driver ...................................................................................................................... file  
  stores  file  path .................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\framework/cache/data  
  stores  file  lock_path ............................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\framework/cache/data  
  stores  memcached  driver ............................................................................................................ memcached  
  stores  memcached  persistent_id .......................................................................................................... null  
  stores  memcached  sasl  0 ............................................................................................................... null  
  stores  memcached  sasl  1 ............................................................................................................... null  
  stores  memcached  options .................................................................................................................. []  
  stores  memcached  servers  0  host ................................................................................................ 127.0.0.1  
  stores  memcached  servers  0  port .................................................................................................... 11211  
  stores  memcached  servers  0  weight .................................................................................................... 100  
  stores  redis  driver .................................................................................................................... redis  
  stores  redis  connection ................................................................................................................ cache  
  stores  redis  lock_connection ......................................................................................................... default  
  stores  dynamodb  driver .............................................................................................................. dynamodb  
***REDACTED_LINE***
***REDACTED_LINE***
  stores  dynamodb  region ............................................................................................................. us-east-1  
  stores  dynamodb  table .................................................................................................................. cache  
  stores  dynamodb  endpoint ................................................................................................................ null  
  stores  octane  driver .................................................................................................................. octane  
  stores  failover  driver .............................................................................................................. failover  
  stores  failover  stores  0 .......................................................................................................... database  
  stores  failover  stores  1 ............................................................................................................. array  
  prefix ............................................................................................................................ laravel-cache-  

```

### artisan config:show database (redacted)

```

  database .........................................................................................................................................  
  default ................................................................................................................................... sqlite  
  connections  sqlite  driver ............................................................................................................. sqlite  
  connections  sqlite  url .................................................................................................................. null  
  connections  sqlite  database ............................. C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\database\database.sqlite  
  connections  sqlite  prefix ....................................................................................................................  
  connections  sqlite  foreign_key_constraints .............................................................................................. true  
  connections  sqlite  busy_timeout ......................................................................................................... null  
  connections  sqlite  journal_mode ......................................................................................................... null  
  connections  sqlite  synchronous .......................................................................................................... null  
  connections  sqlite  transaction_mode ................................................................................................. DEFERRED  
  connections  mysql  driver ............................................................................................................... mysql  
  connections  mysql  url ................................................................................................................... null  
  connections  mysql  host ............................................................................................................. 127.0.0.1  
  connections  mysql  port .................................................................................................................. 3306  
  connections  mysql  database ........................................................................................................... laravel  
  connections  mysql  username .............................................................................................................. root  
***REDACTED_LINE***
  connections  mysql  unix_socket ................................................................................................................  
  connections  mysql  charset ............................................................................................................ utf8mb4  
  connections  mysql  collation ............................................................................................... utf8mb4_unicode_ci  
  connections  mysql  prefix .....................................................................................................................  
  connections  mysql  prefix_indexes ........................................................................................................ true  
  connections  mysql  strict ................................................................................................................ true  
  connections  mysql  engine ................................................................................................................ null  
  connections  mysql  options ................................................................................................................. []  
  connections  mariadb  driver ........................................................................................................... mariadb  
  connections  mariadb  url ................................................................................................................. null  
  connections  mariadb  host ........................................................................................................... 127.0.0.1  
  connections  mariadb  port ................................................................................................................ 3306  
  connections  mariadb  database ......................................................................................................... laravel  
  connections  mariadb  username ............................................................................................................ root  
***REDACTED_LINE***
  connections  mariadb  unix_socket ..............................................................................................................  
  connections  mariadb  charset .......................................................................................................... utf8mb4  
  connections  mariadb  collation ............................................................................................. utf8mb4_unicode_ci  
  connections  mariadb  prefix ...................................................................................................................  
  connections  mariadb  prefix_indexes ...................................................................................................... true  
  connections  mariadb  strict .............................................................................................................. true  
  connections  mariadb  engine .............................................................................................................. null  
  connections  mariadb  options ............................................................................................................... []  
  connections  pgsql  driver ............................................................................................................... pgsql  
  connections  pgsql  url ................................................................................................................... null  
  connections  pgsql  host ............................................................................................................. 127.0.0.1  
  connections  pgsql  port .................................................................................................................. 5432  
  connections  pgsql  database ........................................................................................................... laravel  
  connections  pgsql  username .............................................................................................................. root  
***REDACTED_LINE***
  connections  pgsql  charset ............................................................................................................... utf8  
  connections  pgsql  prefix .....................................................................................................................  
  connections  pgsql  prefix_indexes ........................................................................................................ true  
  connections  pgsql  search_path ......................................................................................................... public  
  connections  pgsql  sslmode ............................................................................................................. prefer  
  connections  sqlsrv  driver ............................................................................................................. sqlsrv  
  connections  sqlsrv  url .................................................................................................................. null  
  connections  sqlsrv  host ............................................................................................................ localhost  
  connections  sqlsrv  port ................................................................................................................. 1433  
  connections  sqlsrv  database .......................................................................................................... laravel  
  connections  sqlsrv  username ............................................................................................................. root  
***REDACTED_LINE***
  connections  sqlsrv  charset .............................................................................................................. utf8  
  connections  sqlsrv  prefix ....................................................................................................................  
  connections  sqlsrv  prefix_indexes ....................................................................................................... true  
  migrations  table .................................................................................................................... migrations  
  migrations  update_date_on_publish ......................................................................................................... true  
  redis  client .......................................................................................................................... phpredis  
  redis  options  cluster .................................................................................................................. redis  
  redis  options  prefix ....................................................................................................... laravel-database-  
  redis  options  persistent ............................................................................................................... false  
  redis  default  url ....................................................................................................................... null  
  redis  default  host ................................................................................................................. 127.0.0.1  
  redis  default  username .................................................................................................................. null  
***REDACTED_LINE***
  redis  default  port ...................................................................................................................... 6379  
  redis  default  database ..................................................................................................................... 0  
  redis  default  max_retries .................................................................................................................. 3  
  redis  default  backoff_algorithm .......................................................................................... decorrelated_jitter  
  redis  default  backoff_base ............................................................................................................... 100  
  redis  default  backoff_cap ............................................................................................................... 1000  
  redis  cache  url ......................................................................................................................... null  
  redis  cache  host ................................................................................................................... 127.0.0.1  
  redis  cache  username .................................................................................................................... null  
***REDACTED_LINE***
  redis  cache  port ........................................................................................................................ 6379  
  redis  cache  database ....................................................................................................................... 1  
  redis  cache  max_retries .................................................................................................................... 3  
  redis  cache  backoff_algorithm ............................................................................................ decorrelated_jitter  
  redis  cache  backoff_base ................................................................................................................. 100  
  redis  cache  backoff_cap ................................................................................................................. 1000  

```

### artisan config:show filesystems (redacted)

```

  filesystems ......................................................................................................................................  
  default .................................................................................................................................... local  
  disks  local  driver ..................................................................................................................... local  
  disks  local  root ............................................. C: ***REDACTED***
  disks  local  serve ....................................................................................................................... true  
  disks  local  throw ...................................................................................................................... false  
  disks  local  report ..................................................................................................................... false  
  disks  public  driver .................................................................................................................... local  
  disks  public  root ............................................. C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\app/public  
  disks  public  url .................................................................................................... http://localhost/storage  
  disks  public  visibility ............................................................................................................... public  
  disks  public  throw ..................................................................................................................... false  
  disks  public  report .................................................................................................................... false  
  disks  s3  driver ........................................................................................................................... s3  
***REDACTED_LINE***
***REDACTED_LINE***
  disks  s3  region .................................................................................................................... us-east-1  
  disks  s3  bucket ..............................................................................................................................  
  disks  s3  url ............................................................................................................................ null  
  disks  s3  endpoint ....................................................................................................................... null  
  disks  s3  use_path_style_endpoint ....................................................................................................... false  
  disks  s3  throw ......................................................................................................................... false  
  disks  s3  report ........................................................................................................................ false  
  links  C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\public\storage  C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\app/public  

```

### artisan config:show logging (redacted)

```

  logging ..........................................................................................................................................  
  default .................................................................................................................................... stack  
  deprecations  channel ...................................................................................................................... null  
  deprecations  trace ....................................................................................................................... false  
  channels  stack  driver .................................................................................................................. stack  
  channels  stack  channels  0 ........................................................................................................... single  
  channels  stack  ignore_exceptions ....................................................................................................... false  
  channels  single  driver ................................................................................................................ single  
  channels  single  path .................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\logs/laravel.log  
  channels  single  level .................................................................................................................. debug  
  channels  single  replace_placeholders .................................................................................................... true  
  channels  daily  driver .................................................................................................................. daily  
  channels  daily  path ..................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\logs/laravel.log  
  channels  daily  level ................................................................................................................... debug  
  channels  daily  days ....................................................................................................................... 14  
  channels  daily  replace_placeholders ..................................................................................................... true  
  channels  slack  driver .................................................................................................................. slack  
  channels  slack  url ...................................................................................................................... null  
  channels  slack  username .......................................................................................................... Laravel Log  
  channels  slack  emoji ................................................................................................................... :boom  
  channels  slack  level ................................................................................................................... debug  
  channels  slack  replace_placeholders ..................................................................................................... true  
  channels  papertrail  driver ........................................................................................................... monolog  
  channels  papertrail  level .............................................................................................................. debug  
  channels  papertrail  handler ................................................................................. Monolog\Handler\SyslogUdpHandler  
  channels  papertrail  handler_with  host ................................................................................................. null  
  channels  papertrail  handler_with  port ................................................................................................. null  
  channels  papertrail  handler_with  connectionString ................................................................................... tls://  
  channels  papertrail  processors  0 .................................................................. Monolog\Processor\PsrLogMessageProcessor  
  channels  stderr  driver ............................................................................................................... monolog  
  channels  stderr  level .................................................................................................................. debug  
  channels  stderr  handler ........................................................................................ Monolog\Handler\StreamHandler  
  channels  stderr  handler_with  stream ........................................................................................... php://stderr  
  channels  stderr  formatter ............................................................................................................... null  
  channels  stderr  processors  0 ...................................................................... Monolog\Processor\PsrLogMessageProcessor  
  channels  syslog  driver ................................................................................................................ syslog  
  channels  syslog  level .................................................................................................................. debug  
  channels  syslog  facility ................................................................................................................... 8  
  channels  syslog  replace_placeholders .................................................................................................... true  
  channels  errorlog  driver ............................................................................................................ errorlog  
  channels  errorlog  level ................................................................................................................ debug  
  channels  errorlog  replace_placeholders .................................................................................................. true  
  channels  null  driver ................................................................................................................. monolog  
  channels  null  handler ............................................................................................ Monolog\Handler\NullHandler  
  channels  emergency  path ................................. C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\logs/laravel.log  

```

### artisan config:show mail (redacted)

```

  mail .............................................................................................................................................  
  default ...................................................................................................................................... log  
  mailers  smtp  transport .................................................................................................................. smtp  
  mailers  smtp  scheme ..................................................................................................................... null  
  mailers  smtp  url ........................................................................................................................ null  
  mailers  smtp  host .................................................................................................................. 127.0.0.1  
  mailers  smtp  port ....................................................................................................................... 2525  
  mailers  smtp  username ................................................................................................................... null  
***REDACTED_LINE***
  mailers  smtp  timeout .................................................................................................................... null  
  mailers  smtp  local_domain .......................................................................................................... localhost  
  mailers  ses  transport .................................................................................................................... ses  
  mailers  postmark  transport .......................................................................................................... postmark  
  mailers  resend  transport .............................................................................................................. resend  
  mailers  sendmail  transport .......................................................................................................... sendmail  
  mailers  sendmail  path .............................................................................................. /usr/sbin/sendmail -bs -i  
  mailers  log  transport .................................................................................................................... log  
  mailers  log  channel ..................................................................................................................... null  
  mailers  array  transport ................................................................................................................ array  
  mailers  failover  transport .......................................................................................................... failover  
  mailers  failover  mailers  0 ............................................................................................................ smtp  
  mailers  failover  mailers  1 ............................................................................................................. log  
  mailers  failover  retry_after .............................................................................................................. 60  
  mailers  roundrobin  transport ...................................................................................................... roundrobin  
  mailers  roundrobin  mailers  0 ........................................................................................................... ses  
  mailers  roundrobin  mailers  1 ...................................................................................................... postmark  
  mailers  roundrobin  retry_after ............................................................................................................ 60  
  from  address ................................................................................................................. hello@example.com  
  from  name .............................................................................................................................. Laravel  
  markdown  theme ......................................................................................................................... default  
  markdown  paths  0 ..................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\resources\views/vendor/mail  

```

### artisan config:show queue (redacted)

```

  queue ............................................................................................................................................  
  default ................................................................................................................................. database  
  connections  sync  driver ................................................................................................................. sync  
  connections  database  driver ......................................................................................................... database  
  connections  database  connection ......................................................................................................... null  
  connections  database  table .............................................................................................................. jobs  
  connections  database  queue ........................................................................................................... default  
  connections  database  retry_after .......................................................................................................... 90  
  connections  database  after_commit ...................................................................................................... false  
  connections  beanstalkd  driver ..................................................................................................... beanstalkd  
  connections  beanstalkd  host ........................................................................................................ localhost  
  connections  beanstalkd  queue ......................................................................................................... default  
  connections  beanstalkd  retry_after ........................................................................................................ 90  
  connections  beanstalkd  block_for ........................................................................................................... 0  
  connections  beanstalkd  after_commit .................................................................................................... false  
  connections  sqs  driver ................................................................................................................... sqs  
***REDACTED_LINE***
***REDACTED_LINE***
  connections  sqs  prefix ................................................................... https://sqs.us-east-1.amazonaws.com/your-account-id  
  connections  sqs  queue ................................................................................................................ default  
  connections  sqs  suffix .................................................................................................................. null  
  connections  sqs  region ............................................................................................................. us-east-1  
  connections  sqs  after_commit ........................................................................................................... false  
  connections  redis  driver ............................................................................................................... redis  
  connections  redis  connection ......................................................................................................... default  
  connections  redis  queue .............................................................................................................. default  
  connections  redis  retry_after ............................................................................................................. 90  
  connections  redis  block_for ............................................................................................................. null  
  connections  redis  after_commit ......................................................................................................... false  
  connections  deferred  driver ......................................................................................................... deferred  
  connections  failover  driver ......................................................................................................... failover  
  connections  failover  connections  0 ................................................................................................ database  
  connections  failover  connections  1 ................................................................................................ deferred  
  connections  background  driver ..................................................................................................... background  
  batching  database ....................................................................................................................... sqlite  
  batching  table ..................................................................................................................... job_batches  
  failed  driver ................................................................................................................... database-uuids  
  failed  database ......................................................................................................................... sqlite  
  failed  table ....................................................................................................................... failed_jobs  

```

### artisan config:show services (redacted)

```

  services .........................................................................................................................................  
***REDACTED_LINE***
***REDACTED_LINE***
***REDACTED_LINE***
***REDACTED_LINE***
  ses  region ........................................................................................................................... us-east-1  
  slack  notifications  bot_user_oauth_token ................................................................................................ null  
  slack  notifications  channel ............................................................................................................. null  

```

### artisan config:show session (redacted)

```

***REDACTED_LINE***
  driver .................................................................................................................................. database  
  lifetime ..................................................................................................................................... 120  
  expire_on_close ............................................................................................................................ false  
  encrypt .................................................................................................................................... false  
  files ..................................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\storage\framework/sessions  
  connection .................................................................................................................................. null  
  table ................................................................................................................................... sessions  
  store ....................................................................................................................................... null  
  lottery  0 .................................................................................................................................... 2  
  lottery  1 .................................................................................................................................. 100  
***REDACTED_LINE***
  path ........................................................................................................................................... /  
  domain ...................................................................................................................................... null  
  secure ...................................................................................................................................... null  
  http_only ................................................................................................................................... true  
  same_site .................................................................................................................................... lax  
  partitioned ................................................................................................................................ false  

```

### artisan route:list (FULL)

```

  GET|HEAD        / ............................................................................................................................................... 
  GET|HEAD        confirm-password ..................................................................... password.confirm  Auth\ConfirmablePasswordController@show
  POST            confirm-password ....................................................................................... Auth\ConfirmablePasswordController@store
  GET|HEAD        dashboard ....................................................................................................... dashboard  DashboardController
  POST            email/verification-notification .......................................... verification.send  Auth\EmailVerificationNotificationController@store
  GET|HEAD        f/{family}/bills ............................................................................... family.bills.index  FamilyBillsController@index
  POST            f/{family}/bills ............................................................................... family.bills.store  FamilyBillsController@store
  GET|HEAD        f/{family}/bills/create ...................................................................... family.bills.create  FamilyBillsController@create
  PUT             f/{family}/bills/{bill} ...................................................................... family.bills.update  FamilyBillsController@update
  DELETE          f/{family}/bills/{bill} .................................................................... family.bills.destroy  FamilyBillsController@destroy
  GET|HEAD        f/{family}/bills/{bill}/edit ..................................................................... family.bills.edit  FamilyBillsController@edit
  POST            f/{family}/bills/{bill}/toggle-active ............................................ family.bills.toggleActive  FamilyBillsController@toggleActive
  GET|HEAD        f/{family}/dashboard ......................................................................... family.dashboard  FamilyDashboardController@index
  GET|HEAD        f/{family}/incomes ................................................................................ incomes.index  FamilyIncomesController@index
  POST            f/{family}/incomes ................................................................................ incomes.store  FamilyIncomesController@store
  PUT|PATCH       f/{family}/incomes/{income} ..................................................................... incomes.update  FamilyIncomesController@update
  DELETE          f/{family}/incomes/{income} ................................................................... incomes.destroy  FamilyIncomesController@destroy
  GET|HEAD        f/{family}/members ......................................................................... family.members.index  FamilyMembersController@index
  POST            f/{family}/members ......................................................................... family.members.store  FamilyMembersController@store
  PUT             f/{family}/members/{member} .............................................................. family.members.update  FamilyMembersController@update
  DELETE          f/{family}/members/{member} ............................................................ family.members.destroy  FamilyMembersController@destroy
  GET|HEAD        f/{family}/ping ................................................................................................................................. 
  GET|HEAD        f/{family}/planpag ................................................................................. family.planpag  FamilyPlanpagPageController
  POST            f/{family}/planpag/{occurrence}/mark-paid ..................................... family.planpag.markPaid  FamilyPlanpagActionsController@markPaid
  POST            f/{family}/planpag/{occurrence}/unmark-paid ............................... family.planpag.unmarkPaid  FamilyPlanpagActionsController@unmarkPaid
  GET|HEAD        f/{family}/taxonomia ................................................................................. family.taxonomy  TaxonomyController@index
  POST            families ................................................................................................ families.store  FamilyController@store
  POST            families/{family}/activate ........................................................................ families.activate  FamilyController@activate
  GET|HEAD        forgot-password ...................................................................... password.request  Auth\PasswordResetLinkController@create
  POST            forgot-password ......................................................................... password.email  Auth\PasswordResetLinkController@store
  GET|HEAD        login ........................................................................................ login  Auth\AuthenticatedSessionController@create
  POST            login ................................................................................................. Auth\AuthenticatedSessionController@store
  POST            logout ..................................................................................... logout  Auth\AuthenticatedSessionController@destroy
  PUT             password ....................................................................................... password.update  Auth\PasswordController@update
  GET|HEAD        planpag ................................................................................................................. PlanpagController@index
  GET|HEAD        profile ................................................................................................... profile.edit  ProfileController@edit
  PATCH           profile ............................................................................................... profile.update  ProfileController@update
  DELETE          profile ............................................................................................. profile.destroy  ProfileController@destroy
  GET|HEAD        register ........................................................................................ register  Auth\RegisteredUserController@create
  POST            register .................................................................................................... Auth\RegisteredUserController@store
  POST            reset-password ................................................................................ password.store  Auth\NewPasswordController@store
  GET|HEAD        reset-password/{token} ....................................................................... password.reset  Auth\NewPasswordController@create
  GET|HEAD        storage/{path} .................................................................................................................... storage.local
  GET|HEAD        taxonomia .............................................................................................................. TaxonomyController@index
  GET|HEAD        up .............................................................................................................................................. 
  GET|HEAD        verify-email ....................................................................... verification.notice  Auth\EmailVerificationPromptController
  GET|HEAD        verify-email/{id}/{hash} ....................................................................... verification.verify  Auth\VerifyEmailController

                                                                                                                                                Showing [47] routes

```

### artisan event:list

```

  Illuminate\Auth\Events\Registered ................................................................................................................  
  OK Illuminate\Auth\Listeners\SendEmailVerificationNotification  
  Illuminate\Console\Events\CommandFinished ........................................................................................................  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php:213  
  Illuminate\Console\Events\CommandStarting ........................................................................................................  
  OK Closure at: /vendor/laravel/pail/src/PailServiceProvider.php:52  
  Illuminate\Database\Events\QueryExecuted .........................................................................................................  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Renderer/Listener.php:60  
  Illuminate\Foundation\Events\LocaleUpdated .......................................................................................................  
  OK Closure at: /vendor/nesbot/carbon/src/Carbon/Laravel/ServiceProvider.php:66  
  Illuminate\Log\Events\MessageLogged ..............................................................................................................  
  OK Closure at: /vendor/laravel/pail/src/PailServiceProvider.php:45  
  Illuminate\Queue\Events\JobAttempted .............................................................................................................  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php:217  
  Illuminate\Queue\Events\JobExceptionOccurred .....................................................................................................  
  OK Closure at: /vendor/laravel/pail/src/PailServiceProvider.php:52  
  Illuminate\Queue\Events\JobProcessed .............................................................................................................  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Renderer/Listener.php:33  
  OK Closure at: /vendor/laravel/pail/src/PailServiceProvider.php:59  
  Illuminate\Queue\Events\JobProcessing ............................................................................................................  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Log/Context/ContextServiceProvider.php:53  
  OK Closure at: /vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Renderer/Listener.php:33  
  OK Closure at: /vendor/laravel/pail/src/PailServiceProvider.php:52  

```

### artisan schedule:list

```

   INFO  No scheduled tasks have been defined.  

```

### artisan migrate:status

```

  Migration name .................................................................................................................... Batch / Status  
  0001_01_01_000000_create_users_table ..................................................................................................... [1] Ran  
  0001_01_01_000001_create_cache_table ..................................................................................................... [1] Ran  
  0001_01_01_000002_create_jobs_table ...................................................................................................... [1] Ran  
  2026_01_23_213624_create_families_table .................................................................................................. [1] Ran  
  2026_01_23_213625_create_family_members_table ............................................................................................ [1] Ran  
  2026_01_23_221245_create_taxonomy_nodes_table ............................................................................................ [1] Ran  
  2026_01_23_222836_create_budget_lines_table .............................................................................................. [1] Ran  
  2026_01_23_222837_create_budget_entries_table ............................................................................................ [1] Ran  
  2026_01_23_223001_create_scenarios_table ................................................................................................. [1] Ran  
  2026_01_23_224940_create_bills_table ..................................................................................................... [1] Ran  
  2026_01_23_225122_create_bill_occurrences_table .......................................................................................... [1] Ran  
  2026_02_04_145800_create_incomes_table ................................................................................................... [2] Ran  

```

### artisan db:show (if available)

```

  SQLite .................................................................................................................................... 3.39.2  
  Connection ................................................................................................................................ sqlite  
  Database .................................................... C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\database\database.sqlite  
  Host .............................................................................................................................................  
  Port .............................................................................................................................................  
  Username .........................................................................................................................................  
  URL ..............................................................................................................................................  
  Open Connections .................................................................................................................................  
  Tables ........................................................................................................................................ 18  

  Schema / Table .............................................................................................................................. Size  
  main / bill_occurrences ........................................................................................................................   
  main / bills ...................................................................................................................................   
  main / budget_entries ..........................................................................................................................   
  main / budget_lines ............................................................................................................................   
  main / cache ...................................................................................................................................   
  main / cache_locks .............................................................................................................................   
  main / failed_jobs .............................................................................................................................   
  main / families ................................................................................................................................   
  main / family_members ..........................................................................................................................   
  main / incomes .................................................................................................................................   
  main / job_batches .............................................................................................................................   
  main / jobs ....................................................................................................................................   
  main / migrations ..............................................................................................................................   
  main / password_reset_tokens ...................................................................................................................   
  main / scenarios ...............................................................................................................................   
  main / sessions ................................................................................................................................   
  main / taxonomy_nodes ..........................................................................................................................   
  main / users ...................................................................................................................................   

```

### artisan queue:failed (if available)

```

   INFO  No failed jobs found.  

```

## Key files (fingerprints)

- `routes/web.php` SHA1: `65a02c788509ded20b954db4fb246e111c1b6842`
- `app/Http/Controllers/FamilyPlanpagActionsController.php` SHA1: `08c091cf41c3662daf8b723c6fa2ae367426eb1c`
- `resources/views/family/planpag.blade.php` SHA1: `210b29676169247478ea186304637bb6bd04d2ad`
- `tests/Feature/PlanpagUiPageTest.php` SHA1: `55d97d8a3b5ce9f0a0b84e29f56d9062ab46bfd6`
- `.githooks/pre-commit` SHA1: `f6d651ab801d828b969e53130886ccac08072177`
- `.githooks/pre-push` SHA1: `e2ac7681c750b0132801eb28370b3ee008b02596`

## Latest local artifacts (captured)


### Latest PlanPag test output

- Latest file: `C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\docs\snapshots\test_planpag_20260127_220035.txt`

```

   PASS  Tests\Feature\PlanpagUiPageTest
  OK family planpag page renders html and lists occurrences in range                                                                   0.61s  
  OK planpag page shows toggle actions based on status                                                                                 0.03s  
  OK member can mark occurrence as paid and defaults paid amount to planned                                                            0.02s  
  OK member can mark occurrence as paid with custom amount                                                                             0.02s  
  OK member can unmark paid occurrence                                                                                                 0.02s  
  OK cannot mark paid for occurrence from another family                                                                               0.03s  
  OK cannot unmark paid for occurrence from another family                                                                             0.02s  

  Tests:    7 passed (44 assertions)
  Duration: 0.87s

```

### Latest full test output

- Latest file: `C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\docs\snapshots\test_full_20260129_090310.txt`

```

   PASS  Tests\Unit\ExampleTest
  OK that true is true                                                                                                                 1.08s  

   PASS  Tests\Feature\ActiveFamilyFlowTest
  OK activate family sets it active and deactivates others                                                                            20.22s  
  OK dashboard redirects to active family dashboard                                                                                    0.31s  

   PASS  Tests\Feature\Auth\AuthenticationTest
  OK login screen can be rendered                                                                                                      6.27s  
  OK users can authenticate using the login screen                                                                                     2.15s  
  OK users can not authenticate with invalid password                                                                                  0.50s  
  OK users can logout                                                                                                                  0.05s  

   PASS  Tests\Feature\Auth\EmailVerificationTest
  OK email verification screen can be rendered                                                                                         0.53s  
  OK email can be verified                                                                                                             0.44s  
  OK email is not verified with invalid hash                                                                                           0.52s  

   PASS  Tests\Feature\Auth\PasswordConfirmationTest
  OK confirm password screen can be rendered                                                                                           1.22s  
  OK password can be confirmed                                                                                                         0.02s  
  OK password is not confirmed with invalid password                                                                                   0.23s  

   PASS  Tests\Feature\Auth\PasswordResetTest
  OK reset password link screen can be rendered                                                                                        1.43s  
  OK reset password link can be requested                                                                                              3.03s  
  OK reset password screen can be rendered                                                                                             2.80s  
  OK password can be reset with valid token                                                                                            0.68s  

   PASS  Tests\Feature\Auth\PasswordUpdateTest
  OK password can be updated                                                                                                           0.02s  
  OK correct password must be provided to update password                                                                              0.07s  

   PASS  Tests\Feature\Auth\RegistrationTest
  OK registration screen can be rendered                                                                                               3.30s  
  OK new users can register                                                                                                            0.12s  

   PASS  Tests\Feature\BillOccurrenceGeneratorTest
  OK generates monthly occurrences idempotently and respects day of month                                                              0.86s  
  OK does not generate for inactive bill                                                                                               0.01s  

   PASS  Tests\Feature\BillPaymentFlowTest
  OK can mark occurrence as paid and store paid fields                                                                                 0.08s  

   PASS  Tests\Feature\BillsUiFlowTest
  OK member can create bill and is redirected to index with success message                                                            5.09s  
  OK member can edit and delete bill                                                                                                   0.42s  
  OK member can toggle bill active status                                                                                              0.04s  

   PASS  Tests\Feature\BudgetBasicsTest
  OK can store 12 months of budget entries and sum                                                                                     0.35s  
  OK budget entry competence is unique per line                                                                                        0.13s  

   PASS  Tests\Feature\EnterActivatesFamilyTest
  OK entering family dashboard auto activates that family                                                                              0.30s  

   PASS  Tests\Feature\ExampleTest
  OK the application returns a successful response                                                                                     0.20s  

   PASS  Tests\Feature\FamilyAccessMiddlewareTest
  OK member can access family route                                                                                                    0.19s  
  OK non member gets 403                                                                                                               0.02s  

   PASS  Tests\Feature\PlanpagEndpointTest
  OK planpag endpoint filters by due date range                                                                                        0.43s  
  OK planpag requires from and to                                                                                                      0.06s  

   PASS  Tests\Feature\PlanpagUiPageTest
  OK family planpag page renders html and lists occurrences in range                                                                   1.59s  
  OK planpag page shows toggle actions based on status                                                                                 0.03s  
  OK member can mark occurrence as paid and defaults paid amount to planned                                                            0.02s  
  OK member can mark occurrence as paid with custom amount                                                                             0.02s  
  OK member can unmark paid occurrence                                                                                                 0.02s  
  OK cannot mark paid for occurrence from another family                                                                               0.15s  
  OK cannot unmark paid for occurrence from another family                                                                             0.02s  

   PASS  Tests\Feature\ProfileTest
  OK profile page is displayed                                                                                                         6.46s  
  OK profile information can be updated                                                                                                0.27s  
  OK email verification status is unchanged when the email address is unchanged                                                        0.01s  
  OK user can delete their account                                                                                                     0.02s  
  OK correct password must be provided to delete account                                                                               0.01s  

   PASS  Tests\Feature\ScopedRoutesAutoActivateFamilyTest
  OK scoped planpag auto activates family                                                                                              0.03s  
  OK scoped taxonomia auto activates family                                                                                            0.08s  

   PASS  Tests\Feature\TaxonomyEndpointTest
  OK taxonomy endpoint returns groups with children                                                                                    0.65s  

   PASS  Tests\Feature\TenancyIsolationTest
  OK user only sees own families via relationship                                                                                      0.02s  

  Tests:    51 passed (670 assertions)
  Duration: 73.14s

```

### Latest routes_full output

- Latest file: `C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\docs\snapshots\routes_full_20260213_183640.txt`

```

  GET|HEAD        / ............................................................................................................................................... 
  GET|HEAD        confirm-password ..................................................................... password.confirm  Auth\ConfirmablePasswordController@show
  POST            confirm-password ....................................................................................... Auth\ConfirmablePasswordController@store
  GET|HEAD        dashboard ....................................................................................................... dashboard  DashboardController
  POST            email/verification-notification .......................................... verification.send  Auth\EmailVerificationNotificationController@store
  GET|HEAD        f/{family}/bills ............................................................................... family.bills.index  FamilyBillsController@index
  POST            f/{family}/bills ............................................................................... family.bills.store  FamilyBillsController@store
  GET|HEAD        f/{family}/bills/create ...................................................................... family.bills.create  FamilyBillsController@create
  PUT             f/{family}/bills/{bill} ...................................................................... family.bills.update  FamilyBillsController@update
  DELETE          f/{family}/bills/{bill} .................................................................... family.bills.destroy  FamilyBillsController@destroy
  GET|HEAD        f/{family}/bills/{bill}/edit ..................................................................... family.bills.edit  FamilyBillsController@edit
  POST            f/{family}/bills/{bill}/toggle-active ............................................ family.bills.toggleActive  FamilyBillsController@toggleActive
  GET|HEAD        f/{family}/dashboard ......................................................................... family.dashboard  FamilyDashboardController@index
  GET|HEAD        f/{family}/incomes ................................................................................ incomes.index  FamilyIncomesController@index
  POST            f/{family}/incomes ................................................................................ incomes.store  FamilyIncomesController@store
  PUT|PATCH       f/{family}/incomes/{income} ..................................................................... incomes.update  FamilyIncomesController@update
  DELETE          f/{family}/incomes/{income} ................................................................... incomes.destroy  FamilyIncomesController@destroy
  GET|HEAD        f/{family}/members ......................................................................... family.members.index  FamilyMembersController@index
  POST            f/{family}/members ......................................................................... family.members.store  FamilyMembersController@store
  PUT             f/{family}/members/{member} .............................................................. family.members.update  FamilyMembersController@update
  DELETE          f/{family}/members/{member} ............................................................ family.members.destroy  FamilyMembersController@destroy
  GET|HEAD        f/{family}/ping ................................................................................................................................. 
  GET|HEAD        f/{family}/planpag ................................................................................. family.planpag  FamilyPlanpagPageController
  POST            f/{family}/planpag/{occurrence}/mark-paid ..................................... family.planpag.markPaid  FamilyPlanpagActionsController@markPaid
  POST            f/{family}/planpag/{occurrence}/unmark-paid ............................... family.planpag.unmarkPaid  FamilyPlanpagActionsController@unmarkPaid
  GET|HEAD        f/{family}/taxonomia ................................................................................. family.taxonomy  TaxonomyController@index
  POST            families ................................................................................................ families.store  FamilyController@store
  POST            families/{family}/activate ........................................................................ families.activate  FamilyController@activate
  GET|HEAD        forgot-password ...................................................................... password.request  Auth\PasswordResetLinkController@create
  POST            forgot-password ......................................................................... password.email  Auth\PasswordResetLinkController@store
  GET|HEAD        login ........................................................................................ login  Auth\AuthenticatedSessionController@create
  POST            login ................................................................................................. Auth\AuthenticatedSessionController@store
  POST            logout ..................................................................................... logout  Auth\AuthenticatedSessionController@destroy
  PUT             password ....................................................................................... password.update  Auth\PasswordController@update
  GET|HEAD        planpag ................................................................................................................. PlanpagController@index
  GET|HEAD        profile ................................................................................................... profile.edit  ProfileController@edit
  PATCH           profile ............................................................................................... profile.update  ProfileController@update
  DELETE          profile ............................................................................................. profile.destroy  ProfileController@destroy
  GET|HEAD        register ........................................................................................ register  Auth\RegisteredUserController@create
  POST            register .................................................................................................... Auth\RegisteredUserController@store
  POST            reset-password ................................................................................ password.store  Auth\NewPasswordController@store
  GET|HEAD        reset-password/{token} ....................................................................... password.reset  Auth\NewPasswordController@create
  GET|HEAD        storage/{path} .................................................................................................................... storage.local
  GET|HEAD        taxonomia .............................................................................................................. TaxonomyController@index
  GET|HEAD        up .............................................................................................................................................. 
  GET|HEAD        verify-email ....................................................................... verification.notice  Auth\EmailVerificationPromptController
  GET|HEAD        verify-email/{id}/{hash} ....................................................................... verification.verify  Auth\VerifyEmailController

                                                                                                                                                Showing [47] routes

```

### Latest timestamp snapshot (short)

- Latest file: `C:\Users\nitro\OneDrive\Documentos\Familyfin novo\familyfin\docs\snapshots\snapshot_20260213_183640.md`

```
# FamilyFin Snapshot

- Generated at: `2026-02-13T18:36:40.2756694-03:00`
- Repo root: `C:/Users/nitro/OneDrive/Documentos/Familyfin novo/familyfin`

## Git

- Branch: `main`
- HEAD: `d8e4164`
- Upstream: `origin/main`

### Status

```
## main...origin/main
```

### Last 15 commits

```
d8e4164 RBAC: authorize bills and planpag via policies (#44)
40e2265 Feat/rbac family members policy (#43)
2303869 RBAC: add family role helpers and authorize incomes via policies (#42)
47bf31e Update snapshots (LATEST + FULL) (#41)
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
[32mPHP[39m version [33m8.2.12[39m (C:\.xampp\php\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.
[32mComposer[39m version [33m2.8.12[39m 2025-09-19 13:41:59
```

### Laravel / Artisan version

```
Laravel Framework 12.48.1
```

## Environment (redacted)

- .env: present 

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

- .env.example: present 

## Key project files (fingerprints)

- `routes/web.php` SHA1: `65a02c788509ded20b954db4fb246e111c1b6842`
- `app/Http/Controllers/FamilyPlanpagActionsController.php` SHA1: `08c091cf41c3662daf8b723c6fa2ae367426eb1c`
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
  GET|HEAD        f/{family}/planpag ................................................................................. family.planpag  FamilyPlanpagPageController
  POST            f/{family}/planpag/{occurrence}/mark-paid ..................................... family.planpag.markPaid  FamilyPlanpagActionsController@markPaid
  POST            f/{family}/planpag/{occurrence}/unmark-paid ............................... family.planpag.unmarkPaid  FamilyPlanpagActionsController@unmarkPaid
  GET|HEAD        planpag ................................................................................................................. PlanpagController@index
```

### Full route:list

- Saved to: `docs\snapshots\routes_full_20260213_183640.txt`

## Notes

- Snapshot redacts secrets by default.
- If route:list / migrate:status fails, it is captured as text and does not stop the snapshot.
```

## Notes

- This file is intentionally maximal, but redacts secrets by default.
- If some artisan commands fail due to missing DB/driver, output is recorded and the snapshot continues.
- Use -NoRedactEnv only if you will NOT paste the output anywhere public.
