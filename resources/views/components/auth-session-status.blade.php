@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-semibold text-sm text-sage-600 dark:text-sage-400']) }}>
        {{ $status }}
    </div>
@endif
