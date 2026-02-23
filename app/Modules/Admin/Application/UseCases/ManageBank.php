<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Application\Contracts\ManageBankInterface;
use App\Modules\Admin\Domain\Contracts\BankRepositoryInterface;
use App\Modules\Admin\Domain\Entities\Bank;

class ManageBank implements ManageBankInterface
{
    private BankRepositoryInterface $repo;

    public function __construct(BankRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(string $name): Bank
    {
        // id 0 indicates new
        return $this->repo->save(new Bank(0, $name));
    }

    public function update(int $id, string $name): Bank
    {
        return $this->repo->save(new Bank($id, $name));
    }

    public function delete(int $id): void
    {
        $existing = $this->repo->findById($id);
        if ($existing) {
            $this->repo->delete($existing);
        }
    }
}
