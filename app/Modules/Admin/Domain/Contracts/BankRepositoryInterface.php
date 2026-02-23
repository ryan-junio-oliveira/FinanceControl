<?php

namespace App\Modules\Admin\Domain\Contracts;

use App\Modules\Admin\Domain\Entities\Bank;

interface BankRepositoryInterface
{
    public function all(): array;
    public function findById(int $id): ?Bank;
    public function save(Bank $bank): Bank;
    public function delete(Bank $bank): void;
}
