<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        $query = Medecin::query()->search($q);
        if ($request->user()->role !== 'admin') {
            $query->where('active', true);
        }

        return response()->json([
            'data' => $query->limit(30)->get(),
        ]);
    }

    public function show(Medecin $medecin): JsonResponse
    {
        return response()->json(['data' => $medecin]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        if ($data['fullname'] === '') {
            return response()->json(['error' => 'fullname requis'], 422);
        }
        $medecin = Medecin::query()->create($data + ['active' => true]);

        return response()->json(['id' => $medecin->id], 201);
    }

    public function update(Request $request, Medecin $medecin): JsonResponse
    {
        $medecin->update($this->validated($request, updating: true));

        return response()->json(['ok' => true]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, bool $updating = false): array
    {
        $data = $request->validate([
            'fullname' => [$updating ? 'sometimes' : 'required', 'string', 'max:190'],
            'type' => ['nullable', 'integer'],
            'region' => ['nullable', 'string', 'max:120'],
            'municipalite' => ['nullable', 'string', 'max:120'],
            'etab' => ['nullable'],
            'name_etab' => ['nullable', 'string', 'max:190'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'tel' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'string', 'max:190'],
            'classe' => ['nullable', 'string', 'max:8'],
            'active' => ['nullable'],
        ]);

        $payload = [
            'fullname' => trim((string) ($data['fullname'] ?? '')),
            'type' => (int) ($data['type'] ?? 1),
            'region' => $data['region'] ?? null,
            'municipalite' => $data['municipalite'] ?? null,
            'etab' => isset($data['etab']) && $data['etab'] !== '' ? (int) $data['etab'] : null,
            'name_etab' => $data['name_etab'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'tel' => $data['tel'] ?? null,
            'email' => $data['email'] ?? null,
            'classe' => ($data['classe'] ?? null) ?: null,
        ];

        if ($updating) {
            $payload['active'] = array_key_exists('active', $data) ? (int) $data['active'] : 1;
        }

        return $payload;
    }
}
