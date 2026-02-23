@extends('layouts.app')

@section('page_title', __('Editar Categoria'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Admin'), 'url' => route('admin.settings')],
    ['label' => __('Categorias'), 'url' => route('admin.categories.index')],
    ['label' => __('Editar categoria')],
]" />

<x-card>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4 p-6">
            <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nome') }}</label>
                <x-form-input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required />
            </div>
            <div>
                @php
                    $typeOptions = collect($types)->map(fn($label,$k)=>['value'=>$k,'label'=>$label])->all();
                @endphp
                <x-form-select name="type" label="{{ __('Tipo') }}" :options="$typeOptions" :value="old('type',$category->type)" required />
            </div>
            <div>
                @php
                    $orgOptions = collect($organizations)->map(fn($org)=>['value'=>$org->id,'label'=>$org->name])->all();
                @endphp
                <x-form-select name="organization_id" label="{{ __('Organização') }}" :options="$orgOptions" :value="old('organization_id',$category->organization_id)" required />
            </div>
        </div>
        <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
            <x-button>{{ __('Atualizar') }}</x-button>
            <x-link variant="secondary" href="{{ route('admin.categories.index') }}">{{ __('Cancelar') }}</x-link>
        </div>
    </form>
</x-card>
@endsection
