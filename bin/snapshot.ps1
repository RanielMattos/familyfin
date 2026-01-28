Param(
  [switch]$TestPlanPag,
  [switch]$TestFull,
  [switch]$MigrateStatus
)

$ErrorActionPreference = "Stop"

New-Item -ItemType Directory -Force -Path "docs\snapshots" | Out-Null

$ts = Get-Date -Format "yyyyMMdd_HHmmss"
$tsFile = "docs\snapshots\snapshot_$ts.md"
$latest = "docs\snapshots\SNAPSHOT_LATEST.md"
$full   = "docs\snapshots\SNAPSHOT_FULL.md"

# 1) Snapshot curto (timestamp)
$genParams = @{
  OutFile = $tsFile
}
if ($TestPlanPag)   { $genParams.TestPlanPag = $true }
if ($TestFull)      { $genParams.TestFull    = $true }
if ($MigrateStatus) { $genParams.MigrateStatus = $true }

& "$PSScriptRoot\familyfin-snapshot.ps1" @genParams

if (!(Test-Path $tsFile)) {
  throw "Snapshot curto NÃO foi criado em: $tsFile. Verifique o familyfin-snapshot.ps1 (param OutFile e escrita no arquivo)."
}

# 2) Atualiza LATEST fixo
Copy-Item -Path $tsFile -Destination $latest -Force
Write-Host "OK: LATEST snapshot updated at $latest"

# 3) Atualiza FULL (completão)
& "$PSScriptRoot\familyfin-full.ps1" -OutFile $full
Write-Host "OK: FULL snapshot updated at $full"

Write-Host ""
Write-Host "DONE: timestamp=$tsFile | latest=$latest | full=$full"
