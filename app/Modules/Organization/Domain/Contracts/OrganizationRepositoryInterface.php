<?php

namespace App\Modules\Organization\Domain\Contracts;

use App\Modules\Organization\Domain\Entities\Organization;

interface OrganizationRepositoryInterface
{
    public function findById(int $id): ?Organization;
    public function listAll(): array;
    public function save(Organization $org): Organization;
    public function delete(Organization $org): void;
}
