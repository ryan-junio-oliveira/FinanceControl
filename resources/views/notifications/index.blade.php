@extends('layouts.app')

@section('page_title','Notificações')

@section('content')
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-4">Notificações recentes</h2>
        @if(auth()->user()->notifications->isEmpty())
            <p>Não há notificações.</p>
        @else
            <ul class="space-y-2">
                @foreach(auth()->user()->notifications as $n)
                    <li class="border p-3 rounded bg-white">
                        <div class="text-sm text-gray-600">{{ $n->created_at->format('d/m/Y H:i') }}</div>
                        <div class="mt-1">
                            @switch($n->data['type'] ?? '')
                                @case('budget_limit')
                                    O orçamento {{ $n->data['budget_name'] }} foi ultrapassado.
                                    @break
                                @case('creditcard_due')
                                    Fatura do cartão {{ $n->data['card_name'] }} vence dia {{ $n->data['due_day'] }}.
                                    @break
                                @case('negative_balance')
                                    Saldo negativo (R$ {{ $n->data['expense'] }} gastos > R$ {{ $n->data['income'] }} receitas).
                                    @break
                                @default
                                    {{ json_encode($n->data) }}
                            @endswitch
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
