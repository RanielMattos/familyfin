<?php

namespace Database\Seeders;

use App\Models\TaxonomyNode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        // Taxonomia global (family_id = null)
        $groups = [
            // Despesas
            ['name' => 'Moradia',        'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Aluguel',
                'Condomínio',
                'Energia',
                'Água',
                'Gás',
                'Internet',
                'Manutenção',
                'Móveis e utensílios',
            ]],
            ['name' => 'Alimentação',    'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Mercado',
                'Feira',
                'Restaurante',
                'Delivery',
            ]],
            ['name' => 'Transporte',     'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Combustível',
                'Transporte público',
                'Aplicativos',
                'Manutenção veicular',
                'Estacionamento',
                'IPVA e taxas',
            ]],
            ['name' => 'Saúde',          'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Plano de saúde',
                'Medicamentos',
                'Consultas e exames',
                'Terapias',
            ]],
            ['name' => 'Educação',       'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Mensalidades',
                'Cursos',
                'Material',
            ]],
            ['name' => 'Dívidas',        'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Cartão de crédito',
                'Empréstimos',
                'Acordos',
                'Juros e tarifas',
            ]],
            ['name' => 'Lazer',          'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Passeios',
                'Streaming e assinaturas',
                'Viagens',
            ]],
            ['name' => 'Pessoais',       'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Beleza',
                'Roupas',
                'Presentes',
            ]],
            ['name' => 'Pet',            'direction' => TaxonomyNode::DIR_EXPENSE, 'categories' => [
                'Ração',
                'Veterinário',
                'Higiene',
            ]],

            // Receitas
            ['name' => 'Renda',          'direction' => TaxonomyNode::DIR_INCOME, 'categories' => [
                'Salário',
                'Autônomo',
                'Benefícios',
                'Renda extra',
            ]],
            ['name' => 'Outras receitas','direction' => TaxonomyNode::DIR_INCOME, 'categories' => [
                'Reembolsos',
                'Vendas',
                'Restituições',
            ]],

            // Neutro (ajuda/organização)
            ['name' => 'Ajustes',        'direction' => TaxonomyNode::DIR_BOTH, 'categories' => [
                'Ajuste de caixa',
                'Transferências',
            ]],
        ];

        foreach ($groups as $gIndex => $group) {
            $groupNode = $this->upsertNode(
                type: TaxonomyNode::TYPE_GROUP,
                direction: $group['direction'],
                name: $group['name'],
                parentId: null,
                sortOrder: ($gIndex + 1) * 10,
                description: $this->groupDescription($group['name'])
            );

            foreach ($group['categories'] as $cIndex => $catName) {
                $this->upsertNode(
                    type: TaxonomyNode::TYPE_CATEGORY,
                    direction: $group['direction'],
                    name: $catName,
                    parentId: $groupNode->id,
                    sortOrder: ($cIndex + 1) * 10,
                    description: null
                );
            }
        }
    }

    private function upsertNode(
        string $type,
        string $direction,
        string $name,
        ?string $parentId,
        int $sortOrder,
        ?string $description
    ): TaxonomyNode {
        $slug = $this->makeSlug($name);

        return TaxonomyNode::query()->updateOrCreate(
            [
                'family_id' => null,
                'type' => $type,
                'slug' => $slug,
            ],
            [
                'parent_id' => $parentId,
                'direction' => $direction,
                'name' => $name,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'description' => $description,
            ]
        );
    }

    private function makeSlug(string $name): string
    {
        // slug seguro, estável e compatível com import/dedupe
        return Str::of($name)->lower()->ascii()->replace(' ', '-')->replace('--', '-')->toString();
    }

    private function groupDescription(string $groupName): string
    {
        return match ($groupName) {
            'Moradia' => 'Gastos para manter a casa funcionando (aluguel, contas, manutenção).',
            'Alimentação' => 'Gastos com comida do dia a dia (mercado, feira, refeições).',
            'Transporte' => 'Gastos para se locomover (combustível, apps, manutenção).',
            'Saúde' => 'Gastos com cuidados de saúde (planos, consultas, remédios).',
            'Educação' => 'Gastos com estudo (mensalidades, cursos, materiais).',
            'Dívidas' => 'Pagamentos de dívidas e custos financeiros (juros, tarifas).',
            'Lazer' => 'Gastos de diversão e descanso (streaming, passeios, viagens).',
            'Pessoais' => 'Gastos pessoais do dia a dia (roupas, beleza, presentes).',
            'Pet' => 'Gastos com animais de estimação.',
            'Renda' => 'Entradas de dinheiro recorrentes (salário, benefícios, trabalhos).',
            'Outras receitas' => 'Entradas eventuais (reembolsos, vendas, restituições).',
            'Ajustes' => 'Movimentações para organização (transferências e ajustes).',
            default => null,
        };
    }
}
