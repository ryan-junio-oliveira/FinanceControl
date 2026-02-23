<?php

namespace App\Modules\Admin\Application\Contracts;

use App\Modules\Admin\Domain\Entities\Category;

interface ManageCategoryInterface
{
    public function create(string $name, string $type, int $organizationId): Category;
    public function update(int $id, string $name, string $type, int $organizationId): Category;
    public function delete(int $id): void;
}
