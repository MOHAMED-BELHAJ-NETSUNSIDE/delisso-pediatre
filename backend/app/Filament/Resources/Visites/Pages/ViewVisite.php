<?php

namespace App\Filament\Resources\Visites\Pages;

use App\Filament\Resources\Visites\VisiteResource;
use App\Models\Visite;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ViewVisite extends ViewRecord
{
    protected static string $resource = VisiteResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;

    public function getHeading(): string | Htmlable | null
    {
        $visite = $this->visite();

        return $visite->medecin?->fullname ?: 'Visite';
    }

    public function getSubheading(): string | Htmlable | null
    {
        $visite = $this->visite();

        return implode(' · ', array_filter([
            $visite->delegue?->name,
            $visite->created_at?->timezone(config('app.timezone'))->format('d/m/Y H:i'),
            $visite->region,
        ]));
    }

    private function visite(): Visite
    {
        /** @var Visite $visite */
        $visite = $this->getRecord();

        return $visite;
    }
}
