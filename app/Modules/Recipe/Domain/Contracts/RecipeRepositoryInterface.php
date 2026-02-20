<?php

namespace App\Modules\Recipe\Domain\Contracts;

use App\Modules\Recipe\Domain\Entities\Recipe;

interface RecipeRepositoryInterface
{
    public function findById(int $id): ?Recipe;
    public function listByOrganization(int $organizationId): array;
    public function save(Recipe $recipe): Recipe;
    public function delete(Recipe $recipe): void;
}
