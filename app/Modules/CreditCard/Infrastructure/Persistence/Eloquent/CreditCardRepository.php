<?php

namespace App\Modules\CreditCard\Infrastructure\Persistence\Eloquent;

use App\Modules\CreditCard\Domain\Contracts\CreditCardRepositoryInterface;
use App\Modules\CreditCard\Domain\Entities\CreditCard as CreditCardEntity;

class CreditCardRepository implements CreditCardRepositoryInterface
{
    public function findById(int $id): ?CreditCardEntity
    {
        $model = CreditCardModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function listByOrganization(int $organizationId): array
    {
        $models = CreditCardModel::where('organization_id', $organizationId)->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function save(CreditCardEntity $card): CreditCardEntity
    {
        // if the domain object didn't already carry the bank name (it may be
        // null when created by the controller), resolve it here so the non-NULL
        // database column is satisfied and denormalization remains in sync.
        $bankName = $card->bankName();
        if ($bankName === null) {
            $bankName = \App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankModel::find($card->bankId())->name ?? null;
        }

        $attributes = [
            'name' => $card->name(),
            'organization_id' => $card->organizationId(),
            'bank_id' => $card->bankId(),
            'bank' => $bankName,
            'statement_amount' => $card->statementAmount(),
            'limit' => $card->limit(),
            'closing_day' => $card->closingDay(),
            'due_day' => $card->dueDay(),
            'is_active' => $card->isActive(),
            'color' => $card->color(),
            'paid' => $card->paid(),
        ];

        $model = CreditCardModel::updateOrCreate(['id' => $card->id()], $attributes);
        return $this->toEntity($model);
    }

    public function delete(CreditCardEntity $card): void
    {
        CreditCardModel::destroy($card->id());
    }

    private function toEntity(CreditCardModel $model): CreditCardEntity
    {
        return new CreditCardEntity(
            $model->id,
            $model->name,
            $model->organization_id,
            $model->bank_id,
            $model->bank,
            (float) $model->statement_amount,
            $model->limit !== null ? (float) $model->limit : null,
            $model->closing_day,
            $model->due_day,
            (bool) $model->is_active,
            $model->color,
            (bool) $model->paid,
        );
    }
}
