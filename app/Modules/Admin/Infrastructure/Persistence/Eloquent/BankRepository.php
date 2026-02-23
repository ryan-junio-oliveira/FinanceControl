<?php

namespace App\Modules\Admin\Infrastructure\Persistence\Eloquent;

use App\Modules\Admin\Domain\Contracts\BankRepositoryInterface;
use App\Modules\Admin\Domain\Entities\Bank as BankEntity;

class BankRepository implements BankRepositoryInterface
{
    public function all(): array
    {
        $models = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel::orderBy('name')->get();
        return $models->map(fn($m) => $this->toEntity($m))->all();
    }

    public function findById(int $id): ?BankEntity
    {
        $model = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function save(BankEntity $bank): BankEntity
    {
        $model = \App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel::updateOrCreate(
            ['id' => $bank->id()],
            ['name' => $bank->name()]
        );

        return $this->toEntity($model);
    }

    public function delete(BankEntity $bank): void
    {
        \App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel::destroy($bank->id());
    }

    private function toEntity(\App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel $m): BankEntity
    {
        return new BankEntity((int)$m->id, $m->name);
    }
}
