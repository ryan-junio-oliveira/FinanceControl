{{-- category form behind component (see app/View/Components/CategoryForm.php) --}}
<x-category-form
    :model="$model"
    :types="$types"
    action="{{ $action }}"
    method="{{ $method ?? 'POST' }}"
    button-label="{{ $buttonLabel }}"
    back-url="{{ $backUrl }}" />
