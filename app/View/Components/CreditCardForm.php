<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class CreditCardForm extends Component
{
    public $model;
    public $banks;
    public $action;
    public $method;
    public $buttonLabel;
    public $backUrl;

    public function __construct(
        $model = null,
        $banks = [],
        string $action,
        string $buttonLabel,
        string $backUrl,
        string $method = 'POST'
    ) {
        $this->model = $model;
        $this->banks = $banks;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->buttonLabel = $buttonLabel;
        $this->backUrl = $backUrl;
    }

    public function render()
    {
        return view('components.credit-card-form');
    }
}
