<?php

namespace Tests\Unit;

use App\Modules\Budget\Application\UseCases\ListBudgets;
use App\Modules\Budget\Domain\Entities\Budget;
use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;
use DateTime;
use PHPUnit\Framework\TestCase;

class BudgetUseCaseTest extends TestCase
{
    public function test_list_budgets_returns_entities()
    {
        $fakeRepo = new class implements BudgetRepositoryInterface {
            public function findById(int $id): ?Budget
            {
                return null;
            }
            public function listByOrganization(int $organizationId, int $perPage = 20, ?int $page = null)
            {
                $items = [
                    new Budget(1, 'Test', 100.0, new DateTime('2026-01-01'), new DateTime('2026-12-31'), null, true, $organizationId),
                ];

                return new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    count($items),
                    $perPage,
                    $page ?: 1
                );
            }
            public function save(Budget $budget): Budget
            {
                return $budget;
            }
            public function delete(Budget $budget): void
            {
            }
            public function calculateSpent(Budget $budget): float
            {
                return 0.0;
            }
        };

        $useCase = new ListBudgets($fakeRepo);
        $result = $useCase->execute(42, 20, 1);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Budget::class, $result->first());
        $this->assertEquals(42, $result->first()->organizationId());
    }
}
