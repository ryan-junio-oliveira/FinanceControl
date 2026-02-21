{{-- budget form moved to reusable component (see app/View/Components/BudgetForm.php) --}}
<x-budget-form
    :model="$model"
    :categories="$categories"
    action="{{ $action }}"
    method="{{ $method ?? 'POST' }}"
    button-label="{{ $buttonLabel }}"
    back-url="{{ $backUrl }}" />
