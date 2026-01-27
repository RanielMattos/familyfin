<?php

namespace App\Console\Commands;

use App\Models\Family;
use App\Services\BillOccurrenceGenerator;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class GenerateBillOccurrences extends Command
{
    /**
     * Exemplos:
     *  php artisan planpag:generate
     *  php artisan planpag:generate --from=2026-01-01 --to=2026-03-31
     *  php artisan planpag:generate --family=01kfv5bk3dg0cp5md6qgbgabx5
     */
    protected $signature = 'planpag:generate
        {--from= : Data inicial (YYYY-MM-DD). Default: primeiro dia do mês atual}
        {--to= : Data final (YYYY-MM-DD). Default: último dia do mês atual}
        {--family= : ULID da família (opcional)}';

    protected $description = 'Gera ocorrências (BillOccurrence) idempotentes para Bills ativas em um intervalo';

    public function handle(BillOccurrenceGenerator $generator): int
    {
        $fromOpt = $this->option('from');
        $toOpt = $this->option('to');
        $familyOpt = $this->option('family');

        $now = CarbonImmutable::now();

        $from = $fromOpt
            ? CarbonImmutable::parse($fromOpt)->startOfDay()
            : $now->startOfMonth()->startOfDay();

        $to = $toOpt
            ? CarbonImmutable::parse($toOpt)->endOfDay()
            : $now->endOfMonth()->endOfDay();

        if ($to < $from) {
            $this->error('Intervalo inválido: --to não pode ser menor que --from.');
            return self::FAILURE;
        }

        $family = null;

        if ($familyOpt) {
            $family = Family::query()->where('id', (string) $familyOpt)->first();

            if (!$family) {
                $this->error('Família não encontrada para o ULID informado.');
                return self::FAILURE;
            }
        }

        $created = $generator->generateForRange($from, $to, $family);

        $scope = $family ? "família={$family->id}" : 'todas as famílias';
        $this->info("Ocorrências criadas: {$created} ({$scope})");
        $this->line("Período: {$from->toDateString()} até {$to->toDateString()}");

        return self::SUCCESS;
    }
}
