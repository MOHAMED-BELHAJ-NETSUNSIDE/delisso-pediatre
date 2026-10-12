@php
    $photo = $getRecord();
    $url = filled($photo?->path)
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($photo->path)
        : null;
@endphp

@if ($url)
    <div
        x-data="{
            open: false,
            show() {
                const box = this.$refs.box
                if (box && box.parentElement !== document.body) {
                    document.body.appendChild(box)
                }
                this.open = true
            },
        }"
        x-on:keydown.escape.window="open = false"
        class="visite-photo"
    >
        <button
            type="button"
            x-on:click="show()"
            aria-label="Agrandir la photo"
            style="display: block; width: 100%; padding: 0; border: 0; background: transparent; cursor: zoom-in;"
        >
            <img
                src="{{ $url }}"
                alt=""
                style="display: block; width: 100%; height: 180px; object-fit: cover; border-radius: 0.5rem;"
            />
        </button>

        <div
            x-ref="box"
            x-show="open"
            x-cloak
            x-on:click="open = false"
            class="visite-photo-lightbox"
            style="position: fixed; inset: 0; z-index: 9999; background: rgba(11, 18, 32, 0.86);"
        >
            <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; padding: 1.5rem; box-sizing: border-box;">
                <button
                    type="button"
                    x-on:click.stop="open = false"
                    aria-label="Fermer"
                    style="position: absolute; top: 1rem; right: 1rem; width: 2.5rem; height: 2.5rem; border: 0; border-radius: 999px; background: rgba(255, 255, 255, 0.16); color: white; font-size: 1.5rem; line-height: 1; cursor: pointer;"
                >&times;</button>
                <img
                    src="{{ $url }}"
                    alt=""
                    x-on:click.stop
                    style="display: block; max-width: min(960px, 100%); max-height: 90vh; object-fit: contain; border-radius: 0.75rem;"
                />
            </div>
        </div>
    </div>
@endif
