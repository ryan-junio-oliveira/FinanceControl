<?php

namespace App\Modules\Admin\Application\Contracts;

use App\Modules\Admin\Domain\Entities\Bank;

interface ManageBankInterface
{
    public function create(string $name): Bank;
    public function update(int $id, string $name): Bank;
    public function delete(int $id): void;
}
