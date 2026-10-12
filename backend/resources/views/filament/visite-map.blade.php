@php
    $coords = \App\Models\Visite::coordinates($getState());
@endphp

@if ($coords)
    <div class="space-y-2">
        <div
            wire:ignore
            class="visite-map overflow-hidden rounded-lg ring-1 ring-gray-950/10 dark:ring-white/10"
            style="height: 420px; z-index: 0;"
            x-data
            x-init="(() => {
                const map = L.map($el, { scrollWheelZoom: false }).setView([{{ $coords[0] }}, {{ $coords[1] }}], 16);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);
                L.marker([{{ $coords[0] }}, {{ $coords[1] }}]).addTo(map);
                setTimeout(() => map.invalidateSize(), 200);
            })()"
        ></div>
        <p class="text-sm text-gray-500">{{ $coords[0] }}, {{ $coords[1] }}</p>
    </div>
@else
    <span>{{ filled($getState()) ? $getState() : '—' }}</span>
@endif
