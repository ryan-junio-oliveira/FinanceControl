<?php

namespace App\Modules\CreditCard\Application\Contracts;

use App\Modules\CreditCard\Application\Dto\CreditCardDto;

interface CreditCardViewRepositoryInterface
{
    /**
     * Return a paginated list of credit card DTOs for the given organization.
     *
     * @param int $organizationId
     * @param string|null $search optional search term for card name
     * @param int $perPage number of items per page
     * @param int|null $page explicit page number (uses request default if null)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<CreditCardDto>
     */
    public function listByOrganization(int $organizationId, ?string $search = null, int $perPage = 20, ?int $page = null);
}
