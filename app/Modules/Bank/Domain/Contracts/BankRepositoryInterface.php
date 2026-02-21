<?php

namespace App\Modules\Bank\Domain\Contracts;

use App\Modules\Bank\Domain\Entities\Bank;

interface BankRepositoryInterface
{
    public function findById(int $id): ?Bank;

    /**
     * @return Bank[]
     */
    public function all(): array;

    /**
     * List banks belonging to a given organization.
     *
     * @param int $organizationId
     * @return Bank[]
     */
    public function allByOrganization(int $organizationId): array;

    public function save(Bank $bank): Bank;
    public function delete(Bank $bank): void;
}
