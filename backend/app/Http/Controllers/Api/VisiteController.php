<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use App\Models\VisitePhoto;
use App\Services\VisiteService;
use App\Support\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use RuntimeException;

class VisiteController extends Controller
{
    public function today(Request $request): JsonResponse
    {
        $visites = Visite::query()
            ->where('delegue_id', $request->user()->id)
            ->whereDate('created_at', today());

        $cadeaux = (int) VisiteCadeau::query()
            ->whereHas('visite', fn ($query) => $query
                ->where('delegue_id', $request->user()->id)
                ->whereDate('created_at', today()))
            ->sum('qty');

        return response()->json([
            'data' => [
                'visites' => (clone $visites)->count(),
                'medecins' => (clone $visites)->distinct()->count('medecin_id'),
                'cadeaux' => $cadeaux,
            ],
        ]);
    }

    public function mine(Request $request): JsonResponse
    {
        $rows = Visite::query()
            ->with('medecin:id,fullname')
            ->withSum('lignes as cadeaux_qty', 'qty')
            ->where('delegue_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Visite $visite) => [
                'id' => $visite->id,
                'medecin_name' => $visite->medecin?->fullname,
                'nvisite' => $visite->nvisite,
                'created_at' => $visite->created_at,
                'region' => $visite->region,
                'municipalite' => $visite->municipalite,
                'cadeaux_qty' => (int) $visite->cadeaux_qty,
            ]);

        return response()->json(['data' => $rows]);
    }

    public function show(Request $request, Visite $visite): JsonResponse
    {
        if ($visite->delegue_id !== $request->user()->id) {
            abort(404);
        }

        $visite->load(['medecin:id,fullname', 'lignes.cadeau:id,name', 'photos']);

        return response()->json([
            'data' => [
                'id' => $visite->id,
                'medecin_name' => $visite->medecin?->fullname,
                'nvisite' => $visite->nvisite,
                'classe' => $visite->classe,
                'region' => $visite->region,
                'municipalite' => $visite->municipalite,
                'etab' => $visite->etab ? (Catalog::ETABS[(int) $visite->etab] ?? null) : null,
                'name_etab' => $visite->name_etab,
                'gps' => $visite->gps,
                'remarque' => $visite->remarque,
                'created_at' => $visite->created_at,
                'cadeaux' => $visite->lignes->map(fn (VisiteCadeau $ligne) => [
                    'name' => $ligne->cadeau?->name,
                    'qty' => $ligne->qty,
                ])->values(),
                'photos' => $visite->photos->map(function (VisitePhoto $photo) {
                    $relative = ltrim($photo->path, '/');
                    $absolute = storage_path('app/public/'.$relative);
                    $payload = [
                        'url' => Storage::disk('public')->url($relative),
                    ];
                    if (is_file($absolute)) {
                        $mime = mime_content_type($absolute) ?: 'image/jpeg';
                        $payload['content'] = 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($absolute));
                    }

                    return $payload;
                })->values(),
            ],
        ]);
    }

    public function store(Request $request, VisiteService $visites): JsonResponse
    {
        $payload = $request->all();
        $lignes = $payload['cadeaux'] ?? [];
        if (is_string($lignes)) {
            $lignes = json_decode($lignes, true) ?: [];
        }
        if (! is_array($lignes)) {
            $lignes = [];
        }

        $request->validate([
            'medecin_id' => ['required', 'integer', 'exists:medecins,id'],
            'nvisite' => ['nullable', 'integer', 'min:1', 'max:4'],
            'classe' => ['nullable', 'string', 'max:8'],
            'region' => ['nullable', 'string', 'max:120'],
            'municipalite' => ['nullable', 'string', 'max:120'],
            'etab' => ['nullable'],
            'name_etab' => ['nullable', 'string', 'max:190'],
            'gps' => ['nullable', 'string', 'max:80'],
            'remarque' => ['nullable', 'string'],
        ]);

        $photos = $request->file('photos', []);
        if ($photos && ! is_array($photos)) {
            $photos = [$photos];
        }
        $photos = array_values(array_filter($photos ?? []));
        if ($photos !== []) {
            $request->validate([
                'photos' => ['array', 'max:5'],
                'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        try {
            $visite = $visites->create($request->all(), $lignes, $request->user(), $photos);
        } catch (InvalidArgumentException|RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'id' => $visite->id,
            'message' => 'Visite enregistrée',
        ], 201);
    }
}
