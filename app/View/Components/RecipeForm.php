<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class RecipeForm extends Component
{
    public $model;
    public $categories;
    public $action;
    public $method;
    public $buttonLabel;
    public $backUrl;

    public function __construct(
        string $action,
        string $buttonLabel,
        string $backUrl,
        $model = null,
        $categories = [],
        string $method = 'POST'
    ) {
        $this->model = $model;
        $this->categories = $categories;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->buttonLabel = $buttonLabel;
        $this->backUrl = $backUrl;
    }

    public function render()
    {
        return view('components.recipe-form');
    }
}
