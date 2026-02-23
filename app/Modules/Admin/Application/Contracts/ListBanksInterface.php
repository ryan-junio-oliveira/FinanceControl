<?php

namespace App\Modules\Admin\Application\Contracts;

interface ListBanksInterface
{
    /** @return array */
    public function execute(): array;
}
