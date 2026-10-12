<header class="danino-hero">
    <div class="danino-hero-copy">
        <p class="danino-kicker">Tournée pédiatre</p>
        <h1>{{ $greeting }}</h1>
        <p class="danino-lead">Suivi des visites, des cadeaux remis et des stocks.</p>
        <p class="danino-meta">
            <span>{{ $role }}</span>
            <span>{{ $date }}</span>
        </p>
    </div>
    <div class="danino-hero-metrics">
        @foreach ($metrics as $metric)
            <div class="danino-metric {{ $metric['alert'] ? 'is-alert' : '' }}">
                <span>{{ $metric['label'] }}</span>
                <strong>{{ $metric['value'] }}</strong>
                <small>{{ $metric['hint'] }}</small>
            </div>
        @endforeach
    </div>
</header>
