<?php

namespace Tests\Feature;

use App\Models\Cadeau;
use App\Models\Medecin;
use App\Models\User;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use App\Models\VisitePhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PanelAndApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_opens_filament_and_delegue_is_refused(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $this->actingAs($admin)->get('/admin')->assertOk();

        $delegue = User::factory()->create([
            'email' => 'delegue-test@danino.local',
            'role' => 'delegue',
            'active' => true,
        ]);

        $this->actingAs($delegue)->get('/admin')->assertForbidden();
    }

    public function test_gestionnaire_sees_stock_but_not_medecins(): void
    {
        $user = User::factory()->create([
            'role' => 'gestionnaire',
            'active' => true,
        ]);

        $this->actingAs($user)->get('/admin/cadeaux')->assertOk();
        $this->actingAs($user)->get('/admin/medecins')->assertForbidden();
    }

    public function test_medecin_search_matches_place_phone_and_accents(): void
    {
        $delegue = User::factory()->create(['role' => 'delegue', 'active' => true]);
        Medecin::query()->create([
            'fullname' => 'Dr Amélie Ben Salah',
            'type' => 1,
            'region' => 'Tunis',
            'municipalite' => 'La Marsa',
            'name_etab' => 'Hôpital Charles Nicolle',
            'tel' => '98 111 222',
            'active' => true,
        ]);
        Medecin::query()->create([
            'fullname' => 'Dr Amine Trabelsi',
            'type' => 1,
            'region' => 'Sfax',
            'municipalite' => 'Sfax',
            'name_etab' => 'Cabinet Sfax',
            'active' => true,
        ]);
        Medecin::query()->create([
            'fullname' => 'Dr Inactif',
            'type' => 1,
            'region' => 'Tunis',
            'active' => false,
        ]);

        Sanctum::actingAs($delegue);

        $this->getJson('/api/medecins?q='.urlencode('amelie marsa'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.fullname', 'Dr Amélie Ben Salah');

        $this->getJson('/api/medecins?q='.urlencode('hopital charles'))
            ->assertOk()
            ->assertJsonPath('data.0.name_etab', 'Hôpital Charles Nicolle');

        $this->getJson('/api/medecins?q=98111222')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.fullname', 'Dr Amélie Ben Salah');

        $this->getJson('/api/medecins?q=inactif')
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $this->getJson('/api/medecins')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_mobile_login_returns_a_token(): void
    {
        User::factory()->create([
            'email' => 'delegue-test@danino.local',
            'password' => 'Danino2026!',
            'role' => 'delegue',
            'active' => true,
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'delegue-test@danino.local',
            'password' => 'Danino2026!',
        ])
            ->assertOk()
            ->assertJsonPath('user.role', 'delegue')
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email', 'role']]);
    }

    public function test_delegue_sees_only_their_visit_details(): void
    {
        $delegue = User::factory()->create(['role' => 'delegue', 'active' => true]);
        $other = User::factory()->create(['role' => 'delegue', 'active' => true]);
        $medecin = Medecin::query()->create(['fullname' => 'Dr. Test', 'type' => 1]);
        $cadeau = Cadeau::query()->create(['name' => 'Stylo', 'stock' => 10, 'seuil_alerte' => 1]);
        $visite = Visite::query()->create([
            'medecin_id' => $medecin->id,
            'delegue_id' => $delegue->id,
            'nvisite' => 2,
            'classe' => 'A',
            'region' => 'Tunis',
            'municipalite' => 'La Marsa',
            'etab' => 3,
            'name_etab' => 'Cabinet Test',
            'gps' => '36.8,10.1',
            'remarque' => 'Passage rapide',
        ]);
        VisiteCadeau::query()->create([
            'visite_id' => $visite->id,
            'cadeau_id' => $cadeau->id,
            'qty' => 2,
        ]);
        VisitePhoto::query()->create([
            'visite_id' => $visite->id,
            'path' => 'visites/1/a.jpg',
            'sort_order' => 0,
        ]);

        Sanctum::actingAs($delegue);

        $this->getJson('/api/visites/me/'.$visite->id)
            ->assertOk()
            ->assertJsonPath('data.medecin_name', 'Dr. Test')
            ->assertJsonPath('data.etab', 'Cabinet')
            ->assertJsonPath('data.classe', 'A')
            ->assertJsonPath('data.cadeaux.0.name', 'Stylo')
            ->assertJsonPath('data.cadeaux.0.qty', 2)
            ->assertJsonPath('data.remarque', 'Passage rapide')
            ->assertJsonPath('data.photos.0.url', Storage::disk('public')->url('visites/1/a.jpg'));

        Sanctum::actingAs($other);

        $this->getJson('/api/visites/me/'.$visite->id)->assertNotFound();
    }

    public function test_delegue_sees_only_their_stats_for_today(): void
    {
        $delegue = User::factory()->create(['role' => 'delegue', 'active' => true]);
        $other = User::factory()->create(['role' => 'delegue', 'active' => true]);
        $medecin = Medecin::query()->create(['fullname' => 'Dr. Jour', 'type' => 1]);
        $autreMedecin = Medecin::query()->create(['fullname' => 'Dr. Autre', 'type' => 1]);
        $cadeau = Cadeau::query()->create(['name' => 'Stylo', 'stock' => 20, 'seuil_alerte' => 1]);

        $today = Visite::query()->create([
            'medecin_id' => $medecin->id,
            'delegue_id' => $delegue->id,
            'nvisite' => 1,
        ]);
        $second = Visite::query()->create([
            'medecin_id' => $autreMedecin->id,
            'delegue_id' => $delegue->id,
            'nvisite' => 1,
        ]);
        $yesterday = Visite::query()->create([
            'medecin_id' => $medecin->id,
            'delegue_id' => $delegue->id,
            'nvisite' => 2,
        ]);
        $yesterday->created_at = now()->subDay();
        $yesterday->save();
        $foreign = Visite::query()->create([
            'medecin_id' => $medecin->id,
            'delegue_id' => $other->id,
            'nvisite' => 1,
        ]);

        VisiteCadeau::query()->create(['visite_id' => $today->id, 'cadeau_id' => $cadeau->id, 'qty' => 2]);
        VisiteCadeau::query()->create(['visite_id' => $second->id, 'cadeau_id' => $cadeau->id, 'qty' => 1]);
        VisiteCadeau::query()->create(['visite_id' => $yesterday->id, 'cadeau_id' => $cadeau->id, 'qty' => 9]);
        VisiteCadeau::query()->create(['visite_id' => $foreign->id, 'cadeau_id' => $cadeau->id, 'qty' => 4]);

        Sanctum::actingAs($delegue);

        $this->getJson('/api/visites/me/today')
            ->assertOk()
            ->assertJsonPath('data.visites', 2)
            ->assertJsonPath('data.medecins', 2)
            ->assertJsonPath('data.cadeaux', 3);
    }

    public function test_delegue_sees_gift_stock_with_image_urls(): void
    {
        $delegue = User::factory()->create(['role' => 'delegue', 'active' => true]);
        Cadeau::query()->create([
            'name' => 'Mug photo',
            'image_path' => 'cadeaux/mug.webp',
            'stock' => 12,
            'seuil_alerte' => 5,
            'active' => true,
        ]);
        Cadeau::query()->create([
            'name' => 'Masqué',
            'stock' => 4,
            'seuil_alerte' => 1,
            'active' => false,
        ]);

        Sanctum::actingAs($delegue);

        $this->getJson('/api/cadeaux')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Mug photo')
            ->assertJsonPath('data.0.stock', 12)
            ->assertJsonPath('data.0.image_url', Storage::disk('public')->url('cadeaux/mug.webp'))
            ->assertJsonMissing(['name' => 'Masqué']);
    }

    public function test_media_route_serves_files_stored_outside_the_public_symlink(): void
    {
        $directory = storage_path('app/public/visites/99');
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $file = $directory.'/photo.jpg';
        file_put_contents($file, 'photo-bytes');

        try {
            $this->get('/media/visites/99/photo.jpg')
                ->assertOk()
                ->assertHeader('cache-control', 'max-age=604800, public');

            $this->get('/media/visites/99/missing.jpg')->assertNotFound();
            $this->get('/media/visites/99/../../.env')->assertNotFound();
        } finally {
            @unlink($file);
        }
    }

    public function test_visit_coordinates_are_parsed_and_shown_on_the_map(): void
    {
        $this->assertSame([36.8, 10.1], Visite::coordinates('36.8, 10.1'));
        $this->assertNull(Visite::coordinates('inconnu'));

        $admin = User::factory()->create(['role' => 'admin', 'active' => true]);
        $delegue = User::factory()->create(['role' => 'delegue', 'active' => true]);
        $medecin = Medecin::query()->create(['fullname' => 'Dr. Carte', 'type' => 1]);
        $visite = Visite::query()->create([
            'medecin_id' => $medecin->id,
            'delegue_id' => $delegue->id,
            'gps' => '36.8512,10.1854',
        ]);

        $directory = storage_path('app/public/visites/'.$visite->id);
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $file = $directory.'/photo.jpg';
        file_put_contents($file, 'photo-bytes');
        VisitePhoto::query()->create([
            'visite_id' => $visite->id,
            'path' => 'visites/'.$visite->id.'/photo.jpg',
            'sort_order' => 0,
        ]);

        try {
            $this->actingAs($admin)
                ->get('/admin/visites/'.$visite->id)
                ->assertOk()
                ->assertSee('visite-map', false)
                ->assertSee('36.8512', false)
                ->assertSee('10.1854', false)
                ->assertSee('Agrandir la photo', false)
                ->assertSee('visite-photo-lightbox', false)
                ->assertSee('/media/visites/'.$visite->id.'/photo.jpg', false);
        } finally {
            @unlink($file);
        }
    }
}
