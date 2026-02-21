{{-- recipe form is now a component (see app/View/Components/RecipeForm.php) --}}
<x-recipe-form
    :model="$model"
    :categories="$categories"
    action="{{ $action }}"
    method="{{ $method ?? 'POST' }}"
    button-label="{{ $buttonLabel }}"
    back-url="{{ $backUrl }}" />
