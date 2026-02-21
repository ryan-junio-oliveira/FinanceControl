{{-- credit card form moved to component (see app/View/Components/CreditCardForm.php) --}}
<x-credit-card-form
    :model="$model"
    :banks="$banks"
    action="{{ $action }}"
    method="{{ $method ?? 'POST' }}"
    button-label="{{ $buttonLabel }}"
    back-url="{{ $backUrl }}" />
