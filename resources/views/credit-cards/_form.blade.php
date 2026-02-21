@php
    // $model may be null for create
    $nameVal = old('name', $model?->name() ?? '');
    $bankIdVal = old('bank_id', $model?->bankId() ?? '');
    $statementVal = old('statement_amount', $model?->statementAmount() ?? '');
    $limitVal = old('limit', $model?->limit() ?? '');
    $closingVal = old('closing_day', $model?->closingDay() ?? '');
    $dueVal = old('due_day', $model?->dueDay() ?? '');
    $activeVal = old('is_active', $model?->isActive() ?? true);
    $colorVal = old('color', $model?->color() ?? null);
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if(!empty($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="Nome do cartão" :value="$nameVal" required placeholder="Ex: Nubank, Inter, Bradesco" />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banco <span class="text-rose-500">*</span></label>
            <select name="bank_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="" disabled>{{ __('Selecione um banco') }}</option>
                @foreach($banks as $b)
                    <option value="{{ $b->id ?? $b->id() }}" {{ (string)$bankIdVal === (string)($b->id ?? $b->id()) ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="statement_amount" label="Valor da fatura (R$)" type="number" step="0.01" :value="$statementVal" required placeholder="0,00" />
            <x-form-input name="limit" label="Limite (opcional)" type="number" step="0.01" :value="$limitVal" placeholder="0,00" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="closing_day" label="Dia de fechamento (1-31)" type="number" min="1" max="31" :value="$closingVal" placeholder="Ex: 28" />
            <x-form-input name="due_day" label="Dia de vencimento (1-31)" type="number" min="1" max="31" :value="$dueVal" placeholder="Ex: 5" />
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <x-form-checkbox name="is_active" :checked="$activeVal" />
                <span class="text-sm font-medium text-gray-700">Cartão ativo</span>
            </label>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cor <span class="text-xs text-gray-400">(opcional)</span></label>
                <div class="flex items-center gap-2">
                    <input type="color" value="{{ $colorVal ?? '#005E7D' }}"
                        oninput="document.getElementById('card_color_text').value = this.value"
                        class="h-9 w-10 cursor-pointer rounded-lg border border-gray-200 p-1" />
                    <x-form-input name="color" id="card_color_text" :value="$colorVal" placeholder="#RRGGBB" class="flex-1" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ $buttonLabel }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">Cancelar</x-link>
    </div>
</form>
