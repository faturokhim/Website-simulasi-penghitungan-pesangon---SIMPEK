@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-1.5 space-y-1 text-xs font-medium text-rose-600']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-start gap-1.5">
                <x-icon name="alert-circle" :size="14" class="mt-0.5" />
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
