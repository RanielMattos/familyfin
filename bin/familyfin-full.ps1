Param(
  [string]$OutFile = "docs\snapshots\SNAPSHOT_FULL.md",

  # Skip sections
  [switch]$NoRoutes,
  [switch]$NoFiles,

  # Safety (NOT recommended)
  [switch]$NoRedactEnv,

  # Optional skips (default is "include everything reasonable")
  [switch]$SkipConfigShow,
  [switch]$SkipComposerInventory,
  [switch]$SkipNodeInventory,
  [switch]$SkipPhpDetails,
  [switch]$SkipLaravelDetails,
  [switch]$SkipGitDeep
)

# Windows PowerShell 5.1 friendly
$ErrorActionPreference = "Continue"

# Force UTF-8 output where possible (helps reduce mojibake)
try {
  $utf8 = New-Object System.Text.UTF8Encoding($false)
  [Console]::OutputEncoding = $utf8
  $OutputEncoding = $utf8
} catch { }

function Have([string]$name) {
  return [bool](Get-Command $name -ErrorAction SilentlyContinue)
}

# Markdown fences without literal backtick in source (ASCII-only)
$bt    = [char]96
$fence = New-Object string($bt, 3)

function Add-Lines([System.Collections.Generic.List[string]]$lines, $items) {
  if ($null -eq $items) { return }
  foreach ($it in $items) {
    if ($null -ne $it) { [void]$lines.Add($it.ToString()) }
  }
}

function Add-Header([System.Collections.Generic.List[string]]$lines, [string]$title) {
  [void]$lines.Add("")
  [void]$lines.Add("## $title")
  [void]$lines.Add("")
}

function Add-SubHeader([System.Collections.Generic.List[string]]$lines, [string]$title) {
  [void]$lines.Add("")
  [void]$lines.Add("### $title")
  [void]$lines.Add("")
}

# ASCII sanitizer for any command output (removes mojibake and symbols)
function Normalize-OutputLine([string]$s) {
  if ($null -eq $s) { return "" }

  # Replace any non-ASCII marker at line start (after indentation) with "OK"
  # This catches checkmarks and other symbols without embedding non-ASCII in this script.
  $s = $s -replace '^(\s*)[^\x20-\x7E]+(\s+)', '${1}OK${2}'

  # Strip any remaining non-ASCII (tabs/newlines preserved by splitting stage)
  $s = $s -replace '[^\x09\x0A\x0D\x20-\x7E]', ''

  return $s
}

function Redact-SensitiveLine([string]$line) {
  $line = Normalize-OutputLine $line
  if ($NoRedactEnv) { return $line }

  # Redact URL credentials: https://user:pass@host / https://token@host
  if ($line -match '(https?://)([^/\s]+)@') {
    $line = $line -replace '(https?://)([^/\s]+)@', '$1***REDACTED***@'
  }

  # Redact common secrets in config outputs
  $pat = '(?i)\b(key|secret|token|password|passwd|private|signature|salt|credential|cookie|session|bearer|oauth|client[_-]?secret|api[_-]?key|access[_-]?key)\b'
  if ($line -match $pat) {
    # KEY=..., KEY: ..., KEY => ...
    if ($line -match '^(.*?)(=|:|=>)\s*(.*)$') {
      return ($matches[1] + $matches[2] + " ***REDACTED***")
    }
    return "***REDACTED_LINE***"
  }

  # Redact long base64-ish blobs (APP_KEY etc)
  if ($line -match '([A-Za-z0-9+/]{40,}={0,2})') {
    return ($line -replace '([A-Za-z0-9+/]{40,}={0,2})', '***REDACTED***')
  }

  return $line
}

function Mask-EnvLine([string]$line) {
  $line = Normalize-OutputLine $line
  if ($NoRedactEnv) { return $line }

  if ($line -match '^\s*#') { return $line }
  if ([string]::IsNullOrWhiteSpace($line)) { return $line }

  if ($line -match '^[A-Za-z_][A-Za-z0-9_]*=') {
    $parts = $line.Split('=', 2)
    $key = $parts[0]
    $val = if ($parts.Count -gt 1) { $parts[1] } else { "" }
    if ([string]::IsNullOrEmpty($val)) { return "$key=" }
    return "$key=***REDACTED***"
  }

  return $line
}

function Add-CodeBlock([System.Collections.Generic.List[string]]$lines, [scriptblock]$cmd, [switch]$Redact) {
  [void]$lines.Add($fence)
  try {
    $out = & $cmd 2>&1
    $had = $false
    foreach ($o in @($out)) {
      $had = $true
      $s = $o.ToString()
      if ($Redact) { $s = Redact-SensitiveLine $s } else { $s = Normalize-OutputLine $s }
      [void]$lines.Add($s)
    }
    if (-not $had) { [void]$lines.Add("(no output)") }
  } catch {
    [void]$lines.Add("(failed: " + (Normalize-OutputLine $_.Exception.Message) + ")")
  }
  [void]$lines.Add($fence)
}

function File-Sha1([string]$path) {
  if (!(Test-Path $path)) { return "- $bt$path$bt SHA1: (missing)" }
  try {
    $h = (Get-FileHash -Algorithm SHA1 $path).Hash.ToLower()
    return "- $bt$path$bt SHA1: $bt$h$bt"
  } catch {
    return "- $bt$path$bt SHA1: (hash failed)"
  }
}

function Add-LatestArtifact([System.Collections.Generic.List[string]]$lines, [string]$glob, [string]$title, [int]$maxLines = 4000) {
  $dir = "docs\snapshots"
  if (!(Test-Path $dir)) { return }

  $f = Get-ChildItem -Path $dir -Filter $glob -ErrorAction SilentlyContinue |
       Sort-Object LastWriteTime -Descending |
       Select-Object -First 1

  if ($null -eq $f) { return }

  Add-SubHeader $lines $title
  [void]$lines.Add("- Latest file: $bt$($f.FullName)$bt")
  [void]$lines.Add("")
  [void]$lines.Add($fence)

  try {
    $i = 0
    foreach ($line in (Get-Content $f.FullName -ErrorAction SilentlyContinue)) {
      $i++
      if ($i -gt $maxLines) {
        [void]$lines.Add("(truncated after $maxLines lines)")
        break
      }
      [void]$lines.Add((Normalize-OutputLine $line.ToString()))
    }
  } catch {
    [void]$lines.Add("(failed reading file: " + (Normalize-OutputLine $_.Exception.Message) + ")")
  }

  [void]$lines.Add($fence)
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

# Top
[void]$lines.Add("# FamilyFin FULL Snapshot (maximal, safe-redacted)")
[void]$lines.Add("")
[void]$lines.Add("- Generated at: $bt$((Get-Date).ToString('o'))$bt")
[void]$lines.Add("- Repo root: $bt$root$bt")
[void]$lines.Add("- Branch: $bt$branch$bt")
[void]$lines.Add("- HEAD: $bt$head$bt")
[void]$lines.Add("- Upstream: $bt$upstream$bt")
[void]$lines.Add("- Safety: secrets redacted = " + ($(if ($NoRedactEnv) { "OFF (DANGEROUS)" } else { "ON" })))
[void]$lines.Add("")

# GIT
Add-Header $lines "Git - Overview"
Add-SubHeader $lines "Remotes"
Add-CodeBlock $lines { git remote -v } -Redact

Add-SubHeader $lines "Status"
Add-CodeBlock $lines { git status -sb }

Add-SubHeader $lines "Last 50 commits"
Add-CodeBlock $lines { git log --oneline -50 }

Add-SubHeader $lines "First commit + total commits"
Add-CodeBlock $lines { git rev-list --max-parents=0 HEAD }
Add-CodeBlock $lines { git rev-list --count HEAD }

if (-not $SkipGitDeep) {
  Add-Header $lines "Git - Deep"
  Add-SubHeader $lines "Branches (local + remote)"
  Add-CodeBlock $lines { git branch -a }

  Add-SubHeader $lines "Tags"
  Add-CodeBlock $lines { git tag -n }

  Add-SubHeader $lines "Describe"
  Add-CodeBlock $lines { git describe --always --dirty --tags }

  Add-SubHeader $lines "Submodules"
  Add-CodeBlock $lines { git submodule status }

  Add-SubHeader $lines "Working tree diff stat"
  Add-CodeBlock $lines { git diff --stat }

  Add-SubHeader $lines "Tracked files (paths)"
  if (-not $NoFiles) { Add-CodeBlock $lines { git ls-files } }

  Add-SubHeader $lines "Tracked files (tree with blob ids + sizes)"
  if (-not $NoFiles) { Add-CodeBlock $lines { git ls-tree -r --long HEAD } }

  Add-SubHeader $lines "Shortlog (authors)"
  Add-CodeBlock $lines { git shortlog -sn }

  Add-SubHeader $lines "Full history (reverse, detailed)"
  [void]$lines.Add("- From first commit to current, with author + date + subject")
  [void]$lines.Add("")
  Add-CodeBlock $lines { git log --reverse --date=iso --pretty=format:"%h | %ad | %an | %d%n%s%n" }
}

# Hooks
Add-Header $lines "Hooks (local main guard)"
[void]$lines.Add("- core.hooksPath: $bt$hooksPath$bt")
[void]$lines.Add("")
Add-SubHeader $lines ".githooks listing"
[void]$lines.Add($fence)
if (Test-Path ".githooks") {
  try {
    $hookRows = Get-ChildItem -Force ".githooks" | Select-Object Mode, Length, LastWriteTime, Name
    $txt = ($hookRows | Format-Table -AutoSize | Out-String).TrimEnd()
    if ($txt) {
      foreach ($ln in $txt.Split("`n")) { [void]$lines.Add((Normalize-OutputLine $ln)) }
    } else {
      [void]$lines.Add("(empty)")
    }
  } catch {
    [void]$lines.Add("(failed: " + (Normalize-OutputLine $_.Exception.Message) + ")")
  }
} else {
  [void]$lines.Add("(missing .githooks)")
}
[void]$lines.Add($fence)

# Runtime
Add-Header $lines "Runtime"

Add-SubHeader $lines "PowerShell / OS"
Add-CodeBlock $lines { $PSVersionTable }
Add-CodeBlock $lines { Get-CimInstance Win32_OperatingSystem | Select-Object Caption, Version, BuildNumber }

Add-SubHeader $lines "PHP version"
if (Have "php") { Add-CodeBlock $lines { php -v | Select-Object -First 5 } } else { Add-CodeBlock $lines { "(php not found)" } }

if (-not $SkipPhpDetails) {
  Add-SubHeader $lines "PHP ini + modules"
  if (Have "php") {
    Add-CodeBlock $lines { php --ini }
    Add-CodeBlock $lines { php -m }
  } else {
    Add-CodeBlock $lines { "(php not found)" }
  }
}

Add-SubHeader $lines "Composer"
if (Have "composer") {
  Add-CodeBlock $lines { composer --version }
  Add-CodeBlock $lines { composer validate 2>&1 }
  if (-not $SkipComposerInventory) {
    Add-SubHeader $lines "Composer inventory (packages)"
    Add-CodeBlock $lines { composer show --no-ansi }
    Add-SubHeader $lines "Composer inventory (dev packages)"
    Add-CodeBlock $lines { composer show -D --no-ansi }
  }
} else {
  Add-CodeBlock $lines { "(composer not found)" }
}

if (-not $SkipNodeInventory) {
  Add-SubHeader $lines "Node / npm"
  if (Have "node") { Add-CodeBlock $lines { node -v } } else { Add-CodeBlock $lines { "(node not found)" } }
  if (Have "npm") { Add-CodeBlock $lines { npm -v } } else { Add-CodeBlock $lines { "(npm not found)" } }

  if (Test-Path "package.json") {
    Add-SubHeader $lines "package.json fingerprint"
    [void]$lines.Add((File-Sha1 "package.json"))
    [void]$lines.Add((File-Sha1 "package-lock.json"))
    [void]$lines.Add((File-Sha1 "pnpm-lock.yaml"))
    [void]$lines.Add((File-Sha1 "yarn.lock"))

    if (Have "npm") {
      Add-SubHeader $lines "npm ls (depth=0)"
      Add-CodeBlock $lines { npm ls --depth=0 2>&1 }
    }
  }
}

# Lockfile fingerprints
Add-Header $lines "Dependency lockfiles (fingerprints)"
[void]$lines.Add((File-Sha1 "composer.json"))
[void]$lines.Add((File-Sha1 "composer.lock"))
[void]$lines.Add((File-Sha1 "package.json"))
[void]$lines.Add((File-Sha1 "package-lock.json"))
[void]$lines.Add((File-Sha1 "pnpm-lock.yaml"))
[void]$lines.Add((File-Sha1 "yarn.lock"))

# Env (masked full)
Add-Header $lines "Environment (masked)"
if (Test-Path ".env") {
  [void]$lines.Add("- .env: present")
  Add-SubHeader $lines ".env (FULL, masked)"
  [void]$lines.Add($fence)
  foreach ($l in (Get-Content ".env" -ErrorAction SilentlyContinue)) {
    [void]$lines.Add((Mask-EnvLine $l.ToString()))
  }
  [void]$lines.Add($fence)
} else {
  [void]$lines.Add("- .env: missing")
}

if (Test-Path ".env.example") {
  [void]$lines.Add("")
  [void]$lines.Add("- .env.example: present")
  Add-SubHeader $lines ".env.example (masked)"
  [void]$lines.Add($fence)
  foreach ($l in (Get-Content ".env.example" -ErrorAction SilentlyContinue)) {
    [void]$lines.Add((Mask-EnvLine $l.ToString()))
  }
  [void]$lines.Add($fence)
} else {
  [void]$lines.Add("")
  [void]$lines.Add("- .env.example: missing")
}

# Laravel / Artisan
if (-not $SkipLaravelDetails -and (Test-Path "artisan") -and (Have "php")) {
  Add-Header $lines "Laravel / Artisan"

  Add-SubHeader $lines "Artisan version"
  Add-CodeBlock $lines { php artisan --version --no-ansi }

  Add-SubHeader $lines "artisan about"
  Add-CodeBlock $lines { php artisan about --no-ansi 2>&1 } -Redact

  Add-SubHeader $lines "artisan env"
  Add-CodeBlock $lines { php artisan env --no-ansi 2>&1 } -Redact

  if (-not $SkipConfigShow) {
    $configNames = @("app","auth","cache","database","filesystems","logging","mail","queue","services","session")
    foreach ($cfg in $configNames) {
      Add-SubHeader $lines ("artisan config:show " + $cfg + " (redacted)")
      Add-CodeBlock $lines { php artisan config:show $cfg --no-ansi 2>&1 } -Redact
    }
  }

  Add-SubHeader $lines "artisan route:list (FULL)"
  if (-not $NoRoutes) { Add-CodeBlock $lines { php artisan route:list --no-ansi 2>&1 } }

  Add-SubHeader $lines "artisan event:list"
  Add-CodeBlock $lines { php artisan event:list --no-ansi 2>&1 }

  Add-SubHeader $lines "artisan schedule:list"
  Add-CodeBlock $lines { php artisan schedule:list --no-ansi 2>&1 }

  Add-SubHeader $lines "artisan migrate:status"
  Add-CodeBlock $lines { php artisan migrate:status --no-ansi 2>&1 } -Redact

  Add-SubHeader $lines "artisan db:show (if available)"
  Add-CodeBlock $lines { php artisan db:show --no-ansi 2>&1 } -Redact

  Add-SubHeader $lines "artisan queue:failed (if available)"
  Add-CodeBlock $lines { php artisan queue:failed --no-ansi 2>&1 } -Redact
}

# Files inventory
if (-not $NoFiles) {
  Add-Header $lines "Key files (fingerprints)"
  [void]$lines.Add((File-Sha1 "routes/web.php"))
  [void]$lines.Add((File-Sha1 "app/Http/Controllers/FamilyPlanpagActionsController.php"))
  [void]$lines.Add((File-Sha1 "resources/views/family/planpag.blade.php"))
  [void]$lines.Add((File-Sha1 "tests/Feature/PlanpagUiPageTest.php"))
  [void]$lines.Add((File-Sha1 ".githooks/pre-commit"))
  [void]$lines.Add((File-Sha1 ".githooks/pre-push"))
}

# Include latest artifacts inside FULL
Add-Header $lines "Latest local artifacts (captured)"
Add-LatestArtifact $lines "test_planpag_*.txt" "Latest PlanPag test output"
Add-LatestArtifact $lines "test_full_*.txt" "Latest full test output"
Add-LatestArtifact $lines "routes_full_*.txt" "Latest routes_full output"
Add-LatestArtifact $lines "snapshot_*.md" "Latest timestamp snapshot (short)"

# Notes
Add-Header $lines "Notes"
[void]$lines.Add("- This file is intentionally maximal, but redacts secrets by default.")
[void]$lines.Add("- If some artisan commands fail due to missing DB/driver, output is recorded and the snapshot continues.")
[void]$lines.Add("- Use -NoRedactEnv only if you will NOT paste the output anywhere public.")

$lines | Out-File -FilePath $OutFile -Encoding UTF8
Write-Host ("OK: FULL snapshot saved to " + $OutFile)
