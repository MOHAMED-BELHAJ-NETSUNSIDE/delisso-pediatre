<?php

namespace App\Support;

class Catalog
{
    public const ROLES = [
        'admin' => 'Administrateur',
        'gestionnaire' => 'Gestionnaire',
        'statistiques' => 'Statistiques',
        'delegue' => 'Délégué',
    ];

    public const TYPES = [
        1 => 'Pédiatre',
        2 => 'Sage-femme',
    ];

    public const ETABS = [
        1 => 'Hôpital',
        2 => 'Clinique',
        3 => 'Cabinet',
    ];

    public const CLASSES = [
        'A' => 'A',
        'A+' => 'A+',
        'B' => 'B',
        'C' => 'C',
    ];
}
