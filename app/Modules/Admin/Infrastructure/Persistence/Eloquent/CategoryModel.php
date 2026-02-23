<?php

namespace App\Modules\Admin\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'type', 'organization_id'];

    public function recipes()
    {
        return $this->hasMany(\App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel::class, 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(\App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel::class, 'category_id');
    }

    public function organization()
    {
        return $this->belongsTo(\App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel::class, 'organization_id');
    }
}
