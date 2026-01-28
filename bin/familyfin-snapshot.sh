#!/usr/bin/env bash
set -u

# FamilyFin Snapshot (Markdown)
# Safe by default: redacts .env values and avoids heavy commands unless flags are used.

set -o pipefail

WITH_ROUTES=1
WITH_FULL_ROUTES=1
WITH_MIGRATE_STATUS=0
WITH_TESTS_PLANPAG=0
WITH_TESTS_FULL=0
OUT_DIR="docs/snapshots"
OUT_FILE=""
NO_REDACT_ENV=0

usage() {
  cat <<'EOF'
Usage:
  bin/familyfin-snapshot.sh [options]

Options:
  --out <file>            Output file path (default: docs/snapshots/snapshot_YYYYMMDD_HHMMSS.md)
  --no-routes             Do not collect routes
  --no-full-routes        Do not dump full route:list to a side file
  --migrate-status        Try php artisan migrate:status (may require DB)
  --test-planpag          Run php artisan test --filter PlanpagUiPageTest
  --test-full             Run php artisan test (full suite)
  --no-redact-env         DO NOT redact .env values (NOT recommended)
  -h, --help              Show this help
EOF
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --out) OUT_FILE="${2:-}"; shift 2 ;;
    --no-routes) WITH_ROUTES=0; shift ;;
    --no-full-routes) WITH_FULL_ROUTES=0; shift ;;
    --migrate-status) WITH_MIGRATE_STATUS=1; shift ;;
    --test-planpag) WITH_TESTS_PLANPAG=1; shift ;;
    --test-full) WITH_TESTS_FULL=1; shift ;;
    --no-redact-env) NO_REDACT_ENV=1; shift ;;
    -h|--help) usage; exit 0 ;;
    *) echo "Unknown option: $1"; usage; exit 1 ;;
  esac
done

have() { command -v "$1" >/dev/null 2>&1; }

safe_run() {
  local title="$1"; shift
  echo
  echo "### ${title}"
  echo
  if "$@" 2>&1; then
    return 0
  else
    echo "(falhou, mas seguimos em frente)"
    return 0
  fi
}

repo_root() {
  if ! have git; then return 1; fi
  git rev-parse --show-toplevel 2>/dev/null
}

mask_env_line() {
  # Masks everything after '=' keeping only key. Example: DB_PASSWORD=***REDACTED***
  # Keeps empty values intact.
  local line="$1"
  if [[ "$NO_REDACT_ENV" -eq 1 ]]; then
    echo "$line"
    return 0
  fi
  if [[ "$line" =~ ^[A-Za-z_][A-Za-z0-9_]*= ]]; then
    local key="${line%%=*}"
    local val="${line#*=}"
    if [[ -z "$val" ]]; then
      echo "${key}="
    else
      echo "${key}=***REDACTED***"
    fi
  else
    echo "$line"
  fi
}

file_hash() {
  local f="$1"
  if [[ ! -f "$f" ]]; then
    echo "- (missing) \`$f\`"
    return 0
  fi
  if have sha1sum; then
    local h
    h="$(sha1sum "$f" | awk '{print $1}')"
    echo "- \`$f\` SHA1: \`$h\`"
  elif have shasum; then
    local h
    h="$(shasum -a 1 "$f" | awk '{print $1}')"
    echo "- \`$f\` SHA1: \`$h\`"
  else
    echo "- \`$f\` (hash tool not found)"
  fi
}

ROOT="$(repo_root || true)"
if [[ -z "$ROOT" ]]; then
  echo "ERROR: Not inside a git repository (or git not found)."
  exit 1
fi

cd "$ROOT" || exit 1
mkdir -p "$OUT_DIR"

ts="$(date +%Y%m%d_%H%M%S)"
if [[ -z "$OUT_FILE" ]]; then
  OUT_FILE="${OUT_DIR}/snapshot_${ts}.md"
fi

ROUTES_FULL_FILE="${OUT_DIR}/routes_full_${ts}.txt"
MIGRATE_FILE="${OUT_DIR}/migrate_status_${ts}.txt"
TEST_PLANPAG_FILE="${OUT_DIR}/test_planpag_${ts}.txt"
TEST_FULL_FILE="${OUT_DIR}/test_full_${ts}.txt"

{
  echo "# FamilyFin Snapshot"
  echo
  echo "- Generated at: \`$(date -Iseconds 2>/dev/null || date)\`"
  echo "- Repo root: \`$ROOT\`"
  echo

  echo "## Git"
  echo
  echo "- Branch: \`$(git branch --show-current 2>/dev/null || echo "?")\`"
  echo "- HEAD: \`$(git rev-parse --short HEAD 2>/dev/null || echo "?")\`"
  echo "- Upstream: \`$(git rev-parse --abbrev-ref --symbolic-full-name @{u} 2>/dev/null || echo "none")\`"
  echo

  echo "### Status"
  echo
  echo '```'
  git status -sb 2>&1 || true
  echo '```'
  echo

  echo "### Last 15 commits"
  echo
  echo '```'
  git log --oneline -15 2>&1 || true
  echo '```'
  echo

  echo "### Diff stat (working tree)"
  echo
  echo '```'
  git diff --stat 2>&1 || true
  echo '```'
  echo

  echo "## Local main protection (githooks)"
  echo
  echo "- core.hooksPath: \`$(git config --get core.hooksPath 2>/dev/null || echo "(not set)")\`"
  echo
  echo "### .githooks listing"
  echo
  echo '```'
  ls -la .githooks 2>&1 || true
  echo '```'
  echo

  echo "## Runtime"
  echo
  safe_run "PHP version" php -v | sed -n '1,3p' || true
  if have composer; then
    safe_run "Composer version" composer --version || true
  else
    echo
    echo "### Composer version"
    echo
    echo "(composer not found)"
  fi

  if [[ -f artisan ]]; then
    safe_run "Laravel / Artisan version" php artisan --version --no-ansi || true
  fi

  echo
  echo "## Environment (redacted)"
  echo
  if [[ -f .env ]]; then
    echo "- .env: present ✅"
    echo
    echo "### Selected keys"
    echo
    echo '```'
    for k in APP_ENV APP_URL APP_DEBUG DB_CONNECTION DB_HOST DB_PORT DB_DATABASE DB_USERNAME CACHE_DRIVER QUEUE_CONNECTION SESSION_DRIVER MAIL_MAILER; do
      line="$(grep -E "^${k}=" .env 2>/dev/null | head -n 1 || true)"
      if [[ -n "$line" ]]; then
        mask_env_line "$line"
      fi
    done
    echo '```'
  else
    echo "- .env: missing ❌"
  fi
  echo
  if [[ -f .env.example ]]; then
    echo "- .env.example: present ✅"
  else
    echo "- .env.example: missing ❌"
  fi
  echo

  echo "## Key project files (fingerprints)"
  echo
  file_hash "routes/web.php"
  file_hash "app/Http/Controllers/FamilyPlanpagActionsController.php"
  file_hash "resources/views/family/planpag.blade.php"
  file_hash "tests/Feature/PlanpagUiPageTest.php"
  file_hash ".githooks/pre-commit"
  file_hash ".githooks/pre-push"
  echo

  echo "## PlanPag quick scan"
  echo
  echo "### Grep in routes/web.php"
  echo
  echo '```'
  grep -nE "planpag|mark-paid|unmark-paid|FamilyPlanpagActionsController" routes/web.php 2>/dev/null || echo "(no matches)"
  echo '```'
  echo

  if [[ "$WITH_ROUTES" -eq 1 ]]; then
    echo "## Routes"
    echo
    echo "### PlanPag routes (filtered from route:list)"
    echo
    if [[ -f artisan ]]; then
      echo '```'
      php artisan route:list --no-ansi 2>&1 | grep -E "planpag|mark-paid|unmark-paid" || echo "(no matches or route:list failed)"
      echo '```'
    else
      echo "(artisan not found)"
    fi
    echo

    if [[ "$WITH_FULL_ROUTES" -eq 1 ]]; then
      echo "### Full route:list"
      echo
      echo "- Saved to: \`$ROUTES_FULL_FILE\`"
      if [[ -f artisan ]]; then
        php artisan route:list --no-ansi > "$ROUTES_FULL_FILE" 2>&1 || true
      fi
      echo
    fi
  fi

  if [[ "$WITH_MIGRATE_STATUS" -eq 1 ]]; then
    echo "## Migrations"
    echo
    echo "- Saved to: \`$MIGRATE_FILE\`"
    if [[ -f artisan ]]; then
      php artisan migrate:status --no-ansi > "$MIGRATE_FILE" 2>&1 || true
    fi
    echo
  fi

  if [[ "$WITH_TESTS_PLANPAG" -eq 1 ]]; then
    echo "## Tests (PlanPag)"
    echo
    echo "- Saved to: \`$TEST_PLANPAG_FILE\`"
    if [[ -f artisan ]]; then
      php artisan test --filter PlanpagUiPageTest > "$TEST_PLANPAG_FILE" 2>&1 || true
    fi
    echo
  fi

  if [[ "$WITH_TESTS_FULL" -eq 1 ]]; then
    echo "## Tests (Full suite)"
    echo
    echo "- Saved to: \`$TEST_FULL_FILE\`"
    if [[ -f artisan ]]; then
      php artisan test > "$TEST_FULL_FILE" 2>&1 || true
    fi
    echo
  fi

  echo "## Notes"
  echo
  echo "- This snapshot redacts secrets by default."
  echo "- If route:list / migrate:status fails, it is captured as text and does not stop the snapshot."
} > "$OUT_FILE"

echo "OK: Snapshot saved to $OUT_FILE"
if [[ "$WITH_ROUTES" -eq 1 && "$WITH_FULL_ROUTES" -eq 1 ]]; then
  echo "OK: Full routes saved to $ROUTES_FULL_FILE"
fi
if [[ "$WITH_MIGRATE_STATUS" -eq 1 ]]; then
  echo "OK: Migrate status saved to $MIGRATE_FILE"
fi
if [[ "$WITH_TESTS_PLANPAG" -eq 1 ]]; then
  echo "OK: PlanPag test output saved to $TEST_PLANPAG_FILE"
fi
if [[ "$WITH_TESTS_FULL" -eq 1 ]]; then
  echo "OK: Full test output saved to $TEST_FULL_FILE"
fi
