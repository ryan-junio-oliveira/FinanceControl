@php
    $nameVal = old('name', $model->name ?? '');
    $typeVal = old('type', $model->type ?? '');
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if(!empty($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="Nome" :value="$nameVal" required placeholder="Ex: Alimentação, Salário" />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-rose-500">*</span></label>
            <select name="type" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ (string)$typeVal === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ $buttonLabel }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">Cancelar</x-link>
    </div>
</form>
