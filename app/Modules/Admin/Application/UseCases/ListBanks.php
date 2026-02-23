<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Application\Contracts\ListBanksInterface;
use App\Modules\Admin\Domain\Contracts\BankRepositoryInterface;

class ListBanks implements ListBanksInterface
{
    private BankRepositoryInterface $repo;

    public function __construct(BankRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(): array
    {
        return $this->repo->all();
    }
}
