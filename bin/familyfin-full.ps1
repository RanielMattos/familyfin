Param(
  [string]$OutFile = "docs\snapshots\SNAPSHOT_FULL.md",
  [switch]$NoRoutes,
  [switch]$NoFiles,
  [switch]$NoRedactEnv
)

# Windows PowerShell 5.1 compatible
$ErrorActionPreference = "Continue"

function Have([string]$name) {
  return [bool](Get-Command $name -ErrorAction SilentlyContinue)
}

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

if (!(Have "git")) { Write-Error "git not found"; exit 1 }

$root = (git rev-parse --show-toplevel 2>$null)
if ([string]::IsNullOrEmpty($root)) { Write-Error "Not inside a git repo"; exit 1 }

Set-Location $root

New-Item -ItemType Directory -Force -Path "docs\snapshots" | Out-Null

$branch   = (git branch --show-current 2>$null)
$head     = (git rev-parse --short HEAD 2>$null)
$upstream = (git rev-parse --abbrev-ref --symbolic-full-name '@{u}' 2>$null)
if ([string]::IsNullOrEmpty($upstream)) { $upstream = "none" }

$hooksPath = (git config --get core.hooksPath 2>$null)
if ([string]::IsNullOrEmpty($hooksPath)) { $hooksPath = "(not set)" }

$lines = New-Object System.Collections.Generic.List[string]

[void]$lines.Add("# FamilyFin FULL Snapshot (completão)")
[void]$lines.Add("")
[void]$lines.Add("- Generated at: $bt$((Get-Date).ToString('o'))$bt")
[void]$lines.Add("- Repo root: $bt$root$bt")
[void]$lines.Add("- Branch: $bt$branch$bt")
[void]$lines.Add("- HEAD: $bt$head$bt")
[void]$lines.Add("- Upstream: $bt$upstream$bt")
[void]$lines.Add("")

[void]$lines.Add("## Remotes")
[void]$lines.Add("")
Add-CodeBlock $lines { git remote -v }

[void]$lines.Add("")
[void]$lines.Add("## Status")
[void]$lines.Add("")
Add-CodeBlock $lines { git status -sb }

[void]$lines.Add("")
[void]$lines.Add("## Hooks (proteção local)")
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
[void]$lines.Add("### PHP")
[void]$lines.Add("")
if (Have "php") { Add-CodeBlock $lines { php -v | Select-Object -First 3 } } else { Add-CodeBlock $lines { "(php not found)" } }

[void]$lines.Add("")
[void]$lines.Add("### Composer")
[void]$lines.Add("")
if (Have "composer") { Add-CodeBlock $lines { composer --version } } else { Add-CodeBlock $lines { "(composer not found)" } }

if ((Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("### Laravel / Artisan")
  [void]$lines.Add("")
  Add-CodeBlock $lines { php artisan --version --no-ansi }
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
  $keys = @(
    "APP_ENV","APP_URL","APP_DEBUG",
    "DB_CONNECTION","DB_HOST","DB_PORT","DB_DATABASE","DB_USERNAME",
    "CACHE_DRIVER","QUEUE_CONNECTION","SESSION_DRIVER","MAIL_MAILER"
  )
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

if (-not $NoFiles) {
  [void]$lines.Add("")
  [void]$lines.Add("## Files (tracked)")
  [void]$lines.Add("")
  [void]$lines.Add("- Source: git ls-files (somente versionados)")
  [void]$lines.Add("")
  Add-CodeBlock $lines { git ls-files }

  [void]$lines.Add("")
  [void]$lines.Add("### File count")
  [void]$lines.Add("")
  Add-CodeBlock $lines { git ls-files | Measure-Object | ForEach-Object { $_.Count } }
}

if (-not $NoRoutes -and (Test-Path "artisan") -and (Have "php")) {
  [void]$lines.Add("")
  [void]$lines.Add("## Routes (FULL)")
  [void]$lines.Add("")
  Add-CodeBlock $lines { php artisan route:list --no-ansi }
}

[void]$lines.Add("")
[void]$lines.Add("## Git history (FULL)")
[void]$lines.Add("")
[void]$lines.Add("- From first commit to current, with author + date + subject")
[void]$lines.Add("")
Add-CodeBlock $lines { git log --reverse --date=iso --pretty=format:"%h | %ad | %an | %d%n%s%n" }

$lines | Out-File -FilePath $OutFile -Encoding UTF8
Write-Host "OK: FULL snapshot saved to $OutFile"
