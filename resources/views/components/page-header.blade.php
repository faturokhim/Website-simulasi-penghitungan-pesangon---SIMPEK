@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="text-xs font-semibold uppercase tracking-wide text-primary-700">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-0.5 text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-slate-600">{{ $description }}</p>
        @endif
        @if (isset($breadcrumb))
            <div class="mt-3">{{ $breadcrumb }}</div>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
