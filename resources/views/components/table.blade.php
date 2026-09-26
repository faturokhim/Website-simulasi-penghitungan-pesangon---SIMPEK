@props([
    'minWidth' => '640px',
])

<div {{ $attributes->merge(['class' => 'table-shell']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" style="min-width: {{ $minWidth }}">
            {{ $slot }}
        </table>
    </div>
</div>
