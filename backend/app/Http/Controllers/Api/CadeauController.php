<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadeau;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CadeauController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $isStaff = in_array($request->user()->role, ['admin', 'gestionnaire'], true);
        $query = Cadeau::query()->orderBy('name');
        if (! $isStaff) {
            $query->where('active', true);
        }

        $rows = $query->get()->map(fn (Cadeau $cadeau) => $this->payload($cadeau, $isStaff));

        return response()->json(['data' => $rows]);
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(Cadeau $cadeau, bool $full): array
    {
        $data = $cadeau->toArray();
        $data['image_url'] = filled($cadeau->image_path)
            ? Storage::disk('public')->url($cadeau->image_path)
            : null;

        if ($full) {
            return $data;
        }

        return [
            'id' => $cadeau->id,
            'name' => $cadeau->name,
            'image_path' => $cadeau->image_path,
            'image_url' => $data['image_url'],
            'stock' => $cadeau->stock,
            'seuil_alerte' => $cadeau->seuil_alerte,
        ];
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'seuil_alerte' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable'],
        ]);

        $cadeau = Cadeau::query()->create([
            'name' => trim($data['name']),
            'stock' => (int) ($data['stock'] ?? 0),
            'seuil_alerte' => (int) ($data['seuil_alerte'] ?? 10),
            'active' => (int) ($data['active'] ?? 1),
        ]);

        return response()->json(['id' => $cadeau->id], 201);
    }

    public function update(Request $request, Cadeau $cadeau): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'seuil_alerte' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable'],
        ]);

        $cadeau->update([
            'name' => trim($data['name']),
            'seuil_alerte' => (int) ($data['seuil_alerte'] ?? 10),
            'active' => (int) ($data['active'] ?? 1),
        ]);

        return response()->json(['ok' => true]);
    }

    public function stock(Request $request, Cadeau $cadeau, StockService $stock): JsonResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:in,out,adjust'],
            'qty' => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $stock->adjust($cadeau, $data['type'], (int) $data['qty'], $request->user()->id, $data['note'] ?? null);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['ok' => true]);
    }
}
