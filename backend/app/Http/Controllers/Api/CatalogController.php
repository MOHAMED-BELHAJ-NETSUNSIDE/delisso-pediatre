<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etablissement;
use App\Models\User;
use App\Models\Visite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatalogController extends Controller
{
    public function etablissements(): JsonResponse
    {
        return response()->json([
            'data' => Etablissement::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function storeEtablissement(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
        ]);
        Etablissement::query()->create(['name' => trim($data['name'])]);

        return response()->json(['ok' => true], 201);
    }

    public function users(): JsonResponse
    {
        $rows = User::query()->orderBy('name')->get()->map->toApi(withMeta: true);

        return response()->json(['data' => $rows]);
    }

    public function storeUser(Request $request): JsonResponse
    {
        $data = $this->userData($request, creating: true);
        $user = User::query()->create($data);

        return response()->json(['id' => $user->id], 201);
    }

    public function updateUser(Request $request, User $user): JsonResponse
    {
        $data = $this->userData($request, creating: false);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);

        return response()->json(['ok' => true]);
    }

    public function visites(Request $request): JsonResponse
    {
        $query = Visite::query()
            ->with(['medecin:id,fullname', 'delegue:id,name'])
            ->orderByDesc('created_at');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->query('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->query('to'));
        }

        $rows = $query->limit(200)->get()->map(fn (Visite $visite) => $this->visiteRow($visite));

        return response()->json(['data' => $rows]);
    }

    public function showVisite(Visite $visite): JsonResponse
    {
        $visite->load(['medecin:id,fullname', 'delegue:id,name', 'lignes.cadeau:id,name', 'photos']);

        return response()->json([
            'data' => array_merge($this->visiteRow($visite), [
                'cadeaux' => $visite->lignes->map(fn ($ligne) => [
                    'name' => $ligne->cadeau?->name,
                    'qty' => $ligne->qty,
                ])->values(),
                'photos' => $visite->photos,
            ]),
        ]);
    }

    public function stats(Request $request): JsonResponse
    {
        $from = $request->query('from') ?: now()->startOfMonth()->toDateString();
        $to = $request->query('to') ?: now()->toDateString();

        $visites = Visite::query()->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->count();
        $today = Visite::query()->whereDate('created_at', today())->count();
        $low = \App\Models\Cadeau::query()
            ->where('active', true)
            ->whereColumn('stock', '<=', 'seuil_alerte')
            ->orderBy('stock')
            ->get(['id', 'name', 'stock', 'seuil_alerte']);

        $top = \App\Models\VisiteCadeau::query()
            ->selectRaw('cadeaux.name, SUM(visite_cadeaux.qty) as total')
            ->join('cadeaux', 'cadeaux.id', '=', 'visite_cadeaux.cadeau_id')
            ->join('visites', 'visites.id', '=', 'visite_cadeaux.visite_id')
            ->whereDate('visites.created_at', '>=', $from)
            ->whereDate('visites.created_at', '<=', $to)
            ->groupBy('cadeaux.id', 'cadeaux.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => [
                'from' => $from,
                'to' => $to,
                'visites_periode' => $visites,
                'visites_jour' => $today,
                'stock_bas' => $low,
                'top_cadeaux' => $top,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function visiteRow(Visite $visite): array
    {
        return [
            'id' => $visite->id,
            'medecin_id' => $visite->medecin_id,
            'delegue_id' => $visite->delegue_id,
            'nvisite' => $visite->nvisite,
            'classe' => $visite->classe,
            'region' => $visite->region,
            'municipalite' => $visite->municipalite,
            'etab' => $visite->etab,
            'name_etab' => $visite->name_etab,
            'gps' => $visite->gps,
            'remarque' => $visite->remarque,
            'created_at' => $visite->created_at,
            'medecin_name' => $visite->medecin?->fullname,
            'delegue_name' => $visite->delegue?->name,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function userData(Request $request, bool $creating): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'role' => ['required', Rule::in(array_keys(\App\Support\Catalog::ROLES))],
            'active' => ['nullable'],
            'password' => [$creating ? 'required' : 'nullable', 'string', 'min:6'],
        ]);

        $payload = [
            'name' => trim($data['name']),
            'email' => trim($data['email']),
            'role' => $data['role'],
            'active' => (int) ($data['active'] ?? 1),
        ];
        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        return $payload;
    }
}
