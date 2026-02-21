<?php

declare(strict_types=1);

namespace App\Modules\Bank\Application\Contracts;

use App\Contracts\UseCaseInterface;

interface ListBanksInterface extends UseCaseInterface
{
    /**
     * @return array
     */
    public function execute(): array;
}
