<div class="space-y-4">
    <div>
        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nome') }}</label>
        <x-form-input id="name" name="name" type="text" value="{{ old('name', $bank->name ?? '') }}" required autofocus />
    </div>
</div>
