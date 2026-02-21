{{-- expense form is now a component (see app/View/Components/ExpenseForm.php) --}}
<x-expense-form
    :model="$model"
    :categories="$categories"
    :controls="$controls"
    :credit-cards="$creditCards"
    action="{{ $action }}"
    method="{{ $method ?? 'POST' }}"
    button-label="{{ $buttonLabel }}"
    back-url="{{ $backUrl }}" />
