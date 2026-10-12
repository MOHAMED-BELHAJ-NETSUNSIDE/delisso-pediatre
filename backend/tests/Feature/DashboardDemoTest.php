<?php

namespace Tests\Feature;

use App\Filament\Widgets\CadeauxRemisChart;
use App\Filament\Widgets\TourneeStats;
use App\Filament\Widgets\VisitesParJourChart;
use App\Filament\Widgets\VisitesParRegionChart;
use App\Models\Cadeau;
use App\Models\User;
use App\Models\Visite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardDemoTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_data_feeds_the_dashboard(): void
    {
        $this->seed();

        $this->assertGreaterThan(40, Visite::query()->count());
        $this->assertGreaterThan(0, Cadeau::query()->where('active', true)->whereColumn('stock', '<=', 'seuil_alerte')->count());
        $this->assertGreaterThan(0, Visite::query()->whereDate('created_at', today())->count());

        $admin = User::query()->where('email', 'admin@delisso.local')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(TourneeStats::class)
            ->assertSee('Visites du jour')
            ->assertSee('Cadeaux remis')
            ->assertSee('Stocks bas');

        Livewire::actingAs($admin)->test(VisitesParJourChart::class)->assertSee('Visites par jour');
        Livewire::actingAs($admin)->test(CadeauxRemisChart::class)->assertSee('Cadeaux remis');
        Livewire::actingAs($admin)->test(VisitesParRegionChart::class)->assertSee('Visites par région');
    }
}
