<?php

namespace App\Modules\Admin\Application\Contracts;

interface ListCategoriesInterface
{
    /**
     * @param int|null $organizationId
     * @return array
     */
    public function execute(?int $organizationId = null): array;
}
