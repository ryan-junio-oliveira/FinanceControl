@if($errors->any())
    <div class="mb-4 rounded-md bg-red-50 border border-red-100 p-3 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif