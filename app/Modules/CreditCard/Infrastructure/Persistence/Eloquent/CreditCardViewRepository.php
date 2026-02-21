<?php

namespace App\Modules\CreditCard\Infrastructure\Persistence\Eloquent;

use App\Modules\CreditCard\Application\Contracts\CreditCardViewRepositoryInterface;
use App\Modules\CreditCard\Application\Dto\CreditCardDto;

class CreditCardViewRepository implements CreditCardViewRepositoryInterface
{
    /**
     * @param int $organizationId
     * @param string|null $search a partial name to filter by
     * @param int $perPage number of items per page
     * @param int|null $page explicit page override (uses request default otherwise)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<CreditCardDto>
     */
    public function listByOrganization(int $organizationId, ?string $search = null, int $perPage = 20, ?int $page = null)
    {
        $query = CreditCardModel::query()
            ->where('organization_id', $organizationId);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->orderBy('name');

        // use the paginator returned by Eloquent, then map results to DTOs
        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $paginator->getCollection()->transform(function (CreditCardModel $m) {
            return new CreditCardDto(
                $m->id,
                $m->name,
                $m->bank,
                (float) $m->statement_amount,
                $m->limit !== null ? (float) $m->limit : null,
                $m->closing_day,
                $m->due_day,
                (bool) $m->is_active,
                $m->color,
            );
        });

        return $paginator;
    }
}
