@extends('layouts.app')

@section('page_title', 'Paleta de Cores')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Paleta de Cores</h1>
            <p class="text-sm text-gray-500">Preview das variáveis CSS e suas variações (brand, semantic, neutras).</p>
        </div>
        <div>
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg border">Voltar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Brand — var(--color-brand-*)</h2>
            <div class="grid grid-cols-6 gap-3">
                @php
                    $brand = [
                        '25' => '#f3fbfd', '50' => '#eff9fb', '100' => '#dff3f7',
                        '200' => '#bfe6ef', '300' => '#80cfdf', '400' => '#3aa6bf',
                        '500' => '#005E7D', '600' => '#005270', '700' => '#004058',
                        '800' => '#033445', '900' => '#072632', '950' => '#031016',
                    ];
                @endphp

                @foreach($brand as $k => $hex)
                    <div class="rounded-lg overflow-hidden border">
                        <div class="w-full h-16 bg-brand-{{ $k }}"></div>
                        <div class="p-3 text-xs text-gray-700 font-medium">
                            <div>--color-brand-{{ $k }}</div>
                            <div class="mt-1 text-sm text-gray-500">{{ $hex }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Semânticas & Neutras</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 border rounded">
                    <div class="font-semibold mb-2">Success</div>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded bg-success-500"></div>
                        <div class="text-sm text-gray-600">--color-success-500 · #12b76a</div>
                    </div>
                </div>

                <div class="p-4 border rounded">
                    <div class="font-semibold mb-2">Warning</div>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded bg-warning-500"></div>
                        <div class="text-sm text-gray-600">--color-warning-500 · #f79009</div>
                    </div>
                </div>

                <div class="p-4 border rounded">
                    <div class="font-semibold mb-2">Error</div>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded bg-error-500"></div>
                        <div class="text-sm text-gray-600">--color-error-500 · #f04438</div>
                    </div>
                </div>

                <div class="p-4 border rounded">
                    <div class="font-semibold mb-2">Neutral</div>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded bg-gray-100"></div>
                        <div class="text-sm text-gray-600">--color-gray-100 · #f2f4f7</div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold mb-2">Exemplos de uso</h3>
                <div class="flex gap-3 flex-wrap">
                    <button class="px-4 py-2 rounded bg-cyan-800 text-white">Botão primário</button>
                    <button class="px-4 py-2 rounded border">Botão secundário</button>
                    <div class="px-4 py-2 rounded bg-success-500 text-white">Sucesso</div>
                    <div class="px-4 py-2 rounded bg-error-500 text-white">Erro</div>
                    <div class="px-4 py-2 rounded bg-warning-500 text-white">Alerta</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Token CSS (exibir nomes das variáveis)</h2>
        <div class="grid grid-cols-3 gap-3 text-sm text-gray-700">
            <div>--color-brand-500</div>
            <div>--color-success-500</div>
            <div>--color-error-500</div>
            <div>--color-warning-500</div>
            <div>--color-gray-100</div>
            <div>--shadow-focus-ring</div>
        </div>
    </div>
</div>
@endsection