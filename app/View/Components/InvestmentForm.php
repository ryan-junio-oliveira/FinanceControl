<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class InvestmentForm extends Component
{
    public $model;
    public $action;
    public $method;
    public $buttonLabel;
    public $backUrl;
    public $categories;

    public function __construct(
        string $action,
        string $buttonLabel,
        string $backUrl,
        $model = null,
        string $method = 'POST'
    ) {
        $this->model = $model;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->buttonLabel = $buttonLabel;
        $this->backUrl = $backUrl;

        // load investment categories for current user's organization
        $orgId = Auth::user()?->organization_id;
        $this->categories = [];
        if ($orgId) {
            $this->categories = \App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel::
                where('organization_id', $orgId)
                ->where('type', 'investment')
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        }
    }

    public function render()
    {
        return view('components.investment-form');
    }
}
