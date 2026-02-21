@if($errors->any())
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        <div class="flex items-start gap-2.5">
            <x-fa-icon name="exclamation-circle" class="h-4 w-4 mt-0.5 shrink-0 text-red-500" />
            <ul class="space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif