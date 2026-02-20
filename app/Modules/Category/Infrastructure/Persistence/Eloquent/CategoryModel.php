<?php

namespace App\Modules\Category\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'type', 'organization_id'];

    // relationships used by controller validation logic
    public function recipes()
    {
        return $this->hasMany(\App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel::class, 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(\App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel::class, 'category_id');
    }
}
