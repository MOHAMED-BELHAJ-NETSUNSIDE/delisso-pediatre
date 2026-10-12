<header class="delisso-hero">
    <div class="delisso-hero-copy">
        <p class="delisso-kicker">Tournée pédiatre</p>
        <h1>{{ $greeting }}</h1>
        <p class="delisso-lead">Suivi des visites, des cadeaux remis et des stocks.</p>
        <p class="delisso-meta">
            <span>{{ $role }}</span>
            <span>{{ $date }}</span>
        </p>
    </div>
    <div class="delisso-hero-metrics">
        @foreach ($metrics as $metric)
            <div class="delisso-metric {{ $metric['alert'] ? 'is-alert' : '' }}">
                <span>{{ $metric['label'] }}</span>
                <strong>{{ $metric['value'] }}</strong>
                <small>{{ $metric['hint'] }}</small>
            </div>
        @endforeach
    </div>
</header>
