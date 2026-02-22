<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryForm extends Component
{
    public $model;
    public $types;
    public $action;
    public $method;
    public $buttonLabel;
    public $backUrl;

    public function __construct(
        string $action,
        string $buttonLabel,
        string $backUrl,
        $model = null,
        array $types = [],
        string $method = 'POST'
    ) {
        $this->model = $model;
        $this->types = $types;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->buttonLabel = $buttonLabel;
        $this->backUrl = $backUrl;
    }

    public function render()
    {
        return view('components.category-form');
    }
}
