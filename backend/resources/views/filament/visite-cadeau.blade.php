@php
    $ligne = $getRecord();
    $cadeau = $ligne?->cadeau;
    $url = filled($cadeau?->image_path)
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($cadeau->image_path)
        : null;
@endphp

<div style="display: flex; align-items: center; gap: 0.75rem;">
    @if ($url)
        <img
            src="{{ $url }}"
            alt="{{ $cadeau->name }}"
            style="width: 48px; height: 48px; object-fit: cover; border-radius: 0.375rem; flex-shrink: 0;"
        />
    @endif
    <span style="flex: 1; min-width: 0;">{{ $cadeau?->name ?? '—' }}</span>
    <span style="flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; min-width: 1.75rem; height: 1.75rem; padding: 0 0.45rem; border-radius: 0.375rem; background: #fef3c7; color: #92400e; font-size: 0.875rem; font-weight: 600;">{{ $ligne?->qty }}</span>
</div>
