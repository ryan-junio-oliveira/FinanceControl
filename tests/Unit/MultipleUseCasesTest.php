<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;

class MultipleUseCasesTest extends TestCase
{
    public function test_list_expenses_returns_entities()
    {
        $fakeRepo = new class implements \App\Modules\Expense\Domain\Contracts\ExpenseRepositoryInterface {
            public function findById(int $id): ?\App\Modules\Expense\Domain\Entities\Expense { return null; }
            public function listByOrganization(int $org): array { return []; }
            public function save(\App\Modules\Expense\Domain\Entities\Expense $e): \App\Modules\Expense\Domain\Entities\Expense { return $e; }
            public function delete(\App\Modules\Expense\Domain\Entities\Expense $e): void {}
        };
        $useCase = new \App\Modules\Expense\Application\UseCases\ListExpenses($fakeRepo);
        $this->assertIsArray($useCase->execute(1));
    }

    public function test_list_categories_returns_array()
    {
        $fakeRepo = new class implements \App\Modules\Category\Domain\Contracts\CategoryRepositoryInterface {
            public function findById(int $id): ?\App\Modules\Category\Domain\Entities\Category { return null; }
            public function listByOrganization(int $org): array { return []; }
            public function save(\App\Modules\Category\Domain\Entities\Category $c): \App\Modules\Category\Domain\Entities\Category { return $c; }
            public function delete(\App\Modules\Category\Domain\Entities\Category $c): void {}
        };
        $useCase = new \App\Modules\Category\Application\UseCases\ListCategories($fakeRepo);
        $this->assertIsArray($useCase->execute(1));
    }

    public function test_list_recipes_returns_array()
    {
        $fakeRepo = new class implements \App\Modules\Recipe\Domain\Contracts\RecipeRepositoryInterface {
            public function findById(int $id): ?\App\Modules\Recipe\Domain\Entities\Recipe { return null; }
            public function listByOrganization(int $org): array { return []; }
            public function save(\App\Modules\Recipe\Domain\Entities\Recipe $r): \App\Modules\Recipe\Domain\Entities\Recipe { return $r; }
            public function delete(\App\Modules\Recipe\Domain\Entities\Recipe $r): void {}
        };
        $useCase = new \App\Modules\Recipe\Application\UseCases\ListRecipes($fakeRepo);
        $this->assertIsArray($useCase->execute(1));
    }
}
