Param(
  [string]$OutFile = "",
  [switch]$NoRoutes,
  [switch]$NoFullRoutes,
  [switch]$MigrateStatus,
  [switch]$TestPlanPag,
  [switch]$TestFull,
  [switch]$NoRedactEnv
)

# Windows PowerShell 5.1 compatible
$ErrorActionPreference = "Continue"

function Have([string]$name) {
  return [bool](Get-Command $name -ErrorAction SilentlyContinue)
}

# Markdown delimiters without using literal backtick in strings
$bt    = [char]96
$fence = New-Object string($bt, 3)

function Add-Lines([System.Collections.Generic.List[string]]$lines, $items) {
  if ($null -eq $items) { return }
  foreach ($it in $items) {
    if ($null -ne $it) { [void]$lines.Add($it.ToString()) }
  }
}

function Add-CodeBlock([System.Collections.Generic.List[string]]$lines, [scriptblock]$cmd) {
  [void]$lines.Add($fence)
  try {
    $out = & $cmd 2>&1
    if ($out) { Add-Lines $lines $out } else { [void]$lines.Add("(no output)") }
  } catch {
    [void]$lines.Add("(failed: " + $_.Exception.Message + ")")
  }
  [void]$lines.Add($fence)
}

function Mask-EnvLine([string]$line) {
  if ($NoRedactEnv) { return $line }
  if ($line -match '^[A-Za-z_][A-Za-z0-9_]*=') {
    $parts = $line.Split('=', 2)
    $key = $parts[0]
    $val = if ($parts.Count -gt 1) { $parts[1] } else { "" }
    if ([string]::IsNullOrEmpty($val)) { return "$key=" }
    return "$key=***REDACTED***"
  }
  return $line
}

function Sha1([string]$path) {
  if (!(Test-Path $path)) { return "- (missing) $bt$path$bt" }
  try {
    $h = (Get-FileHash -Algorithm SHA1 $path).Hash.ToLower()
    return "- $bt$path$bt SHA1: $bt$h$bt"
  } catch {
    return "- $bt$path$bt (hash failed)"
  }
}

if (!(Have "git")) { Write-Error "git not found"; exit 1 }

$root = (git rev-parse --show-toplevel 2>$null)
if ([string]::IsNullOrEmpty($root)) { Write-Error "Not inside a git repo"; exit 1 }

Set-Location $root

New-Item -ItemType Directory -Force -Path "docs\snapshots" | Out-Null
New-Item -ItemType Directory -Force -Path "bin" | Out-Null

$ts = Get-Date -Format "yyyyMMdd_HHmmss"
if ([string]::IsNullOrEmpty($OutFile)) {
  $OutFile = "docs\snapshots\snapshot_$ts.md"
}

$routesFullFile   = "docs\snapshots\routes_full_$ts.txt"
$migrateFile      = "docs\snapshots\migrate_status_$ts.txt"
$testPlanPagFile  = "docs\snapshots\test_planpag_$ts.txt"
$testFullFile     = "docs\snapshots\test_full_$ts.txt"

$branch = (git branch --show-current 2>$null)
$head = (git rev-parse --short HEAD 2>$null)

$upstream = (git rev-parse --abbrev-ref --symbolic-full-name '@{u}' 2>$null)
if ([string]::IsNullOrEmpty($upstream)) { $upstream = "none" }

$hooksPath = (git config --get core.hooksPath 2>$null)
if ([string]::IsNullOrEmpty($hooksPath)) { $hooksPath = "(not set)" }

$lines = New-Object System.Collections.Generic.List[string]

[void]$lines.Add("# FamilyFin Snapshot")
[void]$lines.Add("")
[void]$lines.Add("- Generated at: $bt$((Get-Date).ToString('o'))$bt")
[void]$lines.Add("- Repo root: $bt$root$bt")
[void]$lines.Add("")

[void]$lines.Add("## Git")
[void]$lines.Add("")
[void]$lines.Add("- Branch: $bt$branch$bt")
[void]$lines.Add("- HEAD: $bt$head$bt")
[void]$lines.Add("- Upstream: $bt$upstream$bt")
[void]$lines.Add("")

[void]$lines.Add("### Status")
[void]$lines.Add("")
Add-CodeBlock $lines { git status -sb }

[void]$lines.Add("")
[void]$lines.Add("### Last 15 commits")
[void]$lines.Add("")
Add-CodeBlock $lines { git log --oneline -15 }

[void]$lines.Add("")
[void]$lines.Add("### Diff stat (working tree)")
[void]$lines.Add("")
Add-CodeBlock $lines { git diff --stat }

[void]$lines.Add("")
[void]$lines.Add("## Local main protection (githooks)")
[void]$lines.Add("")
[void]$lines.Add("- core.hooksPath: $bt$hooksPath$bt")
[void]$lines.Add("")
[void]$lines.Add("### .githooks listing")
[void]$lines.Add("")
[void]$lines.Add($fence)
if (Test-Path ".githooks") {
  try {
    $hookRows = Get-ChildItem -Force ".githooks" | Select-Object Mode, Length, LastWriteTime, Name
    $txt = ($hookRows | Format-Table -AutoSize | Out-String).TrimEnd()
    if ($txt) { Add-Lines $lines ($txt.Split("`n")) } else { [void]$lines.Add("(empty)") }
  } catch {
    [void]$lines.Add("(failed: " + $_.Exception.Message + ")")
  }
} else {
  [void]$lines.Add("(missing .githooks)")
}
[void]$lines.Add($fence)

[void]$lines.Add("")
[void]$lines.Add("## Runtime")
[void]$lines.Add("")
[void]$lines.Add("### PHP version")
[void]$lines.Add("")
if (Have "php") { Add-CodeBlock $lines { php -v | Select-Object -First 3 } } else { Add-CodeBlock $lines { "(php not found)" } }

[void]$lines.Add("")
[void]$lines.Add("### Composer version")
[void]$lines.Add("")
if (Have "composer") { Add-CodeBlock $lines { composer --version } } else { Add-CodeBlock $lines { "(composer not found)" } }

if (Test-Path "artisan") {
  [void]$lines.Add("")
  [void]$lines.Add("### Laravel / Artisan version")
  [void]$lines.Add("")
  if (Have "php") { Add-CodeBlock $lines { php artisan --version --no-ansi } } else { Add-CodeBlock $lines { "(php not found)" } }
}

[void]$lines.Add("")
[void]$lines.Add("## Environment (redacted)")
[void]$lines.Add("")
if (Test-Path ".env") {
  [void]$lines.Add("- .env: present ✅")
  [void]$lines.Add("")
  [void]$lines.Add("### Selected keys")
  [void]$lines.Add("")
  [void]$lines.Add($fence)
  $keys = @("APP_ENV","APP_URL","APP_DEBUG","DB_CONNECTION","DB_HOST","DB_PORT","DB_DATABASE","DB_USERNAME","CACHE_DRIVER","QUEUE_CONNECTION","SESSION_DRIVER","MAIL_MAILER")
  foreach ($k in $keys) {
    $match = Select-String -Path ".env" -Pattern ("^{0}=" -f [regex]::Escape($k)) -ErrorAction SilentlyContinue | Select-Object -First 1
    if ($match) { [void]$lines.Add((Mask-EnvLine $match.Line)) }
  }
  [void]$lines.Add($fence)
} else {
  [void]$lines.Add("- .env: missing ❌")
}

[void]$lines.Add("")
if (Test-Path ".env.example") { [void]$lines.Add("- .env.example: present ✅") } else { [void]$lines.Add("- .env.example: missing ❌") }

[void]$lines.Add("")
[void]$lines.Add("## Key project files (fingerprints)")
[void]$lines.Add("")
[void]$lines.Add((Sha1 "routes/web.php"))
[void]$lines.Add((Sha1 "app/Http/Controllers/FamilyPlanpagActionsController.php"))
[void]$lines.Add((Sha1 "resources/views/family/planpag.blade.php"))
[void]$lines.Add((Sha1 "tests/Feature/PlanpagUiPageTest.php"))
[void]$lines.Add((Sha1 ".githooks/pre-commit"))
[void]$lines.Add((Sha1 ".githooks/pre-push"))

[void]$lines.Add("")
[void]$lines.Add("## PlanPag quick scan")
[void]$lines.Add("")
[void]$lines.Add("### Matches in routes/web.php")
[void]$lines.Add("")
[void]$lines.Add($fence)
if (Test-Path "routes/web.php") {
  $matches = Select-String -Path "routes/web.php" -Pattern "planpag|mark-paid|unmark-paid|FamilyPlanpagActionsController" -ErrorAction SilentlyContinue
  if ($matches) {
    foreach ($m in $matches) {
      [void]$lines.Add(("{0}: {1}" -f $m.LineNumber, $m.Line))
    }
  } else {
    [void]$lines.Add("(no matches)")
  }
} else {
  [void]$lines.Add("(missing routes/web.php)")
}
[void]$lines.Add($fence)

if (-not $NoRoutes -and (Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("## Routes")
  [void]$lines.Add("")
  [void]$lines.Add("### PlanPag routes (filtered from route:list)")
  [void]$lines.Add("")
  $routeList = (php artisan route:list --no-ansi 2>&1)

  [void]$lines.Add($fence)
  $filtered = $routeList | Select-String -Pattern "planpag|mark-paid|unmark-paid" | ForEach-Object { $_.Line }
  if ($filtered) { Add-Lines $lines $filtered } else { [void]$lines.Add("(no matches or route:list failed)") }
  [void]$lines.Add($fence)

  if (-not $NoFullRoutes) {
    [void]$lines.Add("")
    [void]$lines.Add("### Full route:list")
    [void]$lines.Add("")
    [void]$lines.Add("- Saved to: $bt$routesFullFile$bt")
    $routeList | Out-File -FilePath $routesFullFile -Encoding UTF8
  }
}

if ($MigrateStatus -and (Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("## Migrations")
  [void]$lines.Add("")
  [void]$lines.Add("- Saved to: $bt$migrateFile$bt")
  (php artisan migrate:status --no-ansi 2>&1) | Out-File -FilePath $migrateFile -Encoding UTF8
}

if ($TestPlanPag -and (Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("## Tests (PlanPag)")
  [void]$lines.Add("")
  [void]$lines.Add("- Saved to: $bt$testPlanPagFile$bt")
  (php artisan test --filter PlanpagUiPageTest 2>&1) | Out-File -FilePath $testPlanPagFile -Encoding UTF8
}

if ($TestFull -and (Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("## Tests (Full suite)")
  [void]$lines.Add("")
  [void]$lines.Add("- Saved to: $bt$testFullFile$bt")
  (php artisan test 2>&1) | Out-File -FilePath $testFullFile -Encoding UTF8
}

[void]$lines.Add("")
[void]$lines.Add("## Notes")
[void]$lines.Add("")
[void]$lines.Add("- Snapshot redacts secrets by default.")
[void]$lines.Add("- If route:list / migrate:status fails, it is captured as text and does not stop the snapshot.")

$lines | Out-File -FilePath $OutFile -Encoding UTF8

Write-Host "OK: Snapshot saved to $OutFile"
if (-not $NoRoutes -and -not $NoFullRoutes -and (Test-Path $routesFullFile)) { Write-Host "OK: Full routes saved to $routesFullFile" }
if ($MigrateStatus -and (Test-Path $migrateFile)) { Write-Host "OK: Migrate status saved to $migrateFile" }
if ($TestPlanPag -and (Test-Path $testPlanPagFile)) { Write-Host "OK: PlanPag test output saved to $testPlanPagFile" }
if ($TestFull -and (Test-Path $testFullFile)) { Write-Host "OK: Full test output saved to $testFullFile" }
