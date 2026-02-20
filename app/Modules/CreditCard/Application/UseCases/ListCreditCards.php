<?php

namespace App\Modules\CreditCard\Application\UseCases;

use App\Modules\CreditCard\Application\Contracts\CreditCardViewRepositoryInterface;
use App\Modules\CreditCard\Application\Dto\CreditCardDto;

final class ListCreditCards
{
    private CreditCardViewRepositoryInterface $viewRepo;

    public function __construct(CreditCardViewRepositoryInterface $viewRepo)
    {
        $this->viewRepo = $viewRepo;
    }

    /**
     * @return CreditCardDto[]
     */
    /**
     * @param int $organizationId
     * @param string|null $search
     * @param int $perPage
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<CreditCardDto>
     */
    public function execute(int $organizationId, ?string $search = null, int $perPage = 20, ?int $page = null)
    {
        return $this->viewRepo->listByOrganization($organizationId, $search, $perPage, $page);
    }
}
