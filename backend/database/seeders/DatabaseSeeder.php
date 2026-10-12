<?php

namespace Database\Seeders;

use App\Models\Cadeau;
use App\Models\Etablissement;
use App\Models\Medecin;
use App\Models\StockMouvement;
use App\Models\User;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(20261010);

        $password = 'Danino2026!';

        User::query()->create([
            'name' => 'Administrateur',
            'email' => 'admin@danino.local',
            'password' => $password,
            'role' => 'admin',
            'active' => true,
        ]);
        $gestionnaire = User::query()->create([
            'name' => 'Gestionnaire Stock',
            'email' => 'gestionnaire@danino.local',
            'password' => $password,
            'role' => 'gestionnaire',
            'active' => true,
        ]);
        User::query()->create([
            'name' => 'Lecture Stats',
            'email' => 'stats@danino.local',
            'password' => $password,
            'role' => 'statistiques',
            'active' => true,
        ]);

        $delegues = collect([
            ['name' => 'Délégué Médical', 'email' => 'delegue@danino.local'],
            ['name' => 'Sara Ben Youssef', 'email' => 'sara@danino.local'],
            ['name' => 'Karim Jaziri', 'email' => 'karim@danino.local'],
            ['name' => 'Nour Hamdi', 'email' => 'nour@danino.local'],
        ])->map(fn (array $row) => User::query()->create([
            ...$row,
            'password' => $password,
            'role' => 'delegue',
            'active' => true,
        ]));

        $etablissements = [
            'Hôpital Charles Nicolle',
            'Hôpital La Rabta',
            'Clinique El Manar',
            'Clinique Les Jasmins',
            'Cabinet Dr. Amine',
            'Cabinet Dr. Sonia',
            'Polyclinique La Soukra',
        ];
        foreach ($etablissements as $name) {
            Etablissement::query()->create(['name' => $name]);
        }

        $cadeaux = collect([
            ['name' => 'Mug Danino', 'stock' => 160, 'seuil_alerte' => 25],
            ['name' => 'Carnet de santé', 'stock' => 280, 'seuil_alerte' => 40],
            ['name' => 'Toise', 'stock' => 36, 'seuil_alerte' => 18],
            ['name' => 'Porte abaisse-langue', 'stock' => 70, 'seuil_alerte' => 20],
            ['name' => 'Stylo Danino', 'stock' => 220, 'seuil_alerte' => 30],
            ['name' => 'Sac isotherme', 'stock' => 22, 'seuil_alerte' => 12],
        ])->map(function (array $row) use ($gestionnaire) {
            $cadeau = Cadeau::query()->create([...$row, 'active' => true]);
            $mouvement = new StockMouvement;
            $mouvement->forceFill([
                'cadeau_id' => $cadeau->id,
                'type' => 'in',
                'qty' => $row['stock'],
                'user_id' => $gestionnaire->id,
                'note' => 'Stock initial',
                'created_at' => now()->subDays(50),
                'updated_at' => now()->subDays(50),
            ])->save();

            return $cadeau;
        });

        $medecins = collect([
            ['fullname' => 'Dr. Amine Ben Salah', 'type' => 1, 'region' => 'Tunis', 'municipalite' => 'Tunis', 'etab' => 3, 'name_etab' => 'Cabinet Dr. Amine', 'classe' => 'A', 'tel' => '20123456'],
            ['fullname' => 'Sf. Leila Trabelsi', 'type' => 2, 'region' => 'Ariana', 'municipalite' => 'Ariana', 'etab' => 1, 'name_etab' => 'Hôpital Charles Nicolle', 'classe' => 'B', 'tel' => '98111222'],
            ['fullname' => 'Dr. Sonia Gharbi', 'type' => 1, 'region' => 'Tunis', 'municipalite' => 'La Marsa', 'etab' => 2, 'name_etab' => 'Clinique El Manar', 'classe' => 'A+', 'tel' => '71222333'],
            ['fullname' => 'Dr. Hichem Khelifi', 'type' => 1, 'region' => 'Ben Arous', 'municipalite' => 'Ben Arous', 'etab' => 1, 'name_etab' => 'Hôpital La Rabta', 'classe' => 'B', 'tel' => '79444555'],
            ['fullname' => 'Sf. Mariem Chebbi', 'type' => 2, 'region' => 'Sfax', 'municipalite' => 'Sfax', 'etab' => 2, 'name_etab' => 'Clinique Les Jasmins', 'classe' => 'A', 'tel' => '74200110'],
            ['fullname' => 'Dr. Yassine Bouzid', 'type' => 1, 'region' => 'Sousse', 'municipalite' => 'Sousse', 'etab' => 3, 'name_etab' => 'Cabinet Dr. Sonia', 'classe' => 'C', 'tel' => '73222100'],
            ['fullname' => 'Dr. Ines Mejri', 'type' => 1, 'region' => 'Nabeul', 'municipalite' => 'Nabeul', 'etab' => 1, 'name_etab' => 'Hôpital Charles Nicolle', 'classe' => 'A', 'tel' => '72233445'],
            ['fullname' => 'Sf. Rania Jebali', 'type' => 2, 'region' => 'Tunis', 'municipalite' => 'Le Bardo', 'etab' => 2, 'name_etab' => 'Clinique El Manar', 'classe' => 'B', 'tel' => '71555666'],
            ['fullname' => 'Dr. Omar Sassi', 'type' => 1, 'region' => 'Ariana', 'municipalite' => 'Raoued', 'etab' => 3, 'name_etab' => 'Polyclinique La Soukra', 'classe' => 'A+', 'tel' => '70888999'],
            ['fullname' => 'Dr. Salma Ferchichi', 'type' => 1, 'region' => 'Sfax', 'municipalite' => 'Sakiet Ezzit', 'etab' => 1, 'name_etab' => 'Hôpital La Rabta', 'classe' => 'B', 'tel' => '74321000'],
            ['fullname' => 'Dr. Walid Hamrouni', 'type' => 1, 'region' => 'Sousse', 'municipalite' => 'Msaken', 'etab' => 3, 'name_etab' => 'Cabinet Dr. Amine', 'classe' => 'C', 'tel' => '73456789'],
            ['fullname' => 'Sf. Amina Karray', 'type' => 2, 'region' => 'Nabeul', 'municipalite' => 'Hammamet', 'etab' => 2, 'name_etab' => 'Clinique Les Jasmins', 'classe' => 'A', 'tel' => '72200011'],
            ['fullname' => 'Dr. Khaled Ayari', 'type' => 1, 'region' => 'Ben Arous', 'municipalite' => 'Ezzahra', 'etab' => 3, 'name_etab' => 'Cabinet Dr. Sonia', 'classe' => 'B', 'tel' => '79111222'],
            ['fullname' => 'Dr. Nadia Belhadj', 'type' => 1, 'region' => 'Tunis', 'municipalite' => 'Carthage', 'etab' => 2, 'name_etab' => 'Clinique El Manar', 'classe' => 'A+', 'tel' => '71777888'],
            ['fullname' => 'Dr. Fares Mansouri', 'type' => 1, 'region' => 'Sfax', 'municipalite' => 'Sfax', 'etab' => 3, 'name_etab' => 'Cabinet Dr. Amine', 'classe' => 'A', 'tel' => '74999000'],
            ['fullname' => 'Sf. Houda Trabelsi', 'type' => 2, 'region' => 'Ariana', 'municipalite' => 'La Soukra', 'etab' => 1, 'name_etab' => 'Polyclinique La Soukra', 'classe' => 'C', 'tel' => '70333444'],
        ])->map(fn (array $row) => Medecin::query()->create([
            ...$row,
            'adresse' => $row['municipalite'],
            'active' => true,
        ]));

        $stock = $cadeaux->mapWithKeys(fn (Cadeau $cadeau) => [$cadeau->id => $cadeau->stock])->all();
        $preferLow = $cadeaux->filter(fn (Cadeau $cadeau) => in_array($cadeau->name, ['Toise', 'Sac isotherme', 'Porte abaisse-langue'], true))->values();

        $start = now()->subDays(39)->startOfDay();
        for ($day = 0; $day < 40; $day++) {
            $date = $start->copy()->addDays($day);
            $count = $date->isWeekend() ? random_int(0, 2) : random_int(2, 5);
            if ($date->isToday()) {
                $count = max($count, 4);
            }

            for ($i = 0; $i < $count; $i++) {
                /** @var Medecin $medecin */
                $medecin = $medecins->random();
                /** @var User $delegue */
                $delegue = $delegues->random();
                $at = $date->copy()->setTime(random_int(8, 17), [0, 15, 30, 45][random_int(0, 3)]);

                $visite = new Visite;
                $visite->forceFill([
                    'medecin_id' => $medecin->id,
                    'delegue_id' => $delegue->id,
                    'nvisite' => random_int(1, 3),
                    'classe' => $medecin->classe,
                    'region' => $medecin->region,
                    'municipalite' => $medecin->municipalite,
                    'etab' => $medecin->etab,
                    'name_etab' => $medecin->name_etab,
                    'gps' => '36.'.random_int(7000, 8999).',10.'.random_int(1000, 3000),
                    'remarque' => random_int(1, 4) === 1 ? 'Demande de documentation produit' : null,
                    'created_at' => $at,
                    'updated_at' => $at,
                ])->save();

                $picks = $preferLow->concat($cadeaux->random(random_int(1, 2)))->unique('id')->shuffle()->take(random_int(1, 3));
                foreach ($picks as $cadeau) {
                    $qty = in_array($cadeau->name, ['Toise', 'Sac isotherme'], true) ? random_int(1, 2) : random_int(1, 3);
                    if ($stock[$cadeau->id] < $qty) {
                        continue;
                    }
                    $stock[$cadeau->id] -= $qty;
                    VisiteCadeau::query()->create([
                        'visite_id' => $visite->id,
                        'cadeau_id' => $cadeau->id,
                        'qty' => $qty,
                    ]);
                    $mouvement = new StockMouvement;
                    $mouvement->forceFill([
                        'cadeau_id' => $cadeau->id,
                        'type' => 'out',
                        'qty' => $qty,
                        'user_id' => $delegue->id,
                        'visite_id' => $visite->id,
                        'note' => 'Remise visite #'.$visite->id,
                        'created_at' => $at,
                        'updated_at' => $at,
                    ])->save();
                }
            }
        }

        foreach ($cadeaux as $cadeau) {
            $cadeau->update(['stock' => $stock[$cadeau->id]]);
        }
    }
}
