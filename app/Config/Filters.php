<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Alias des filtres disponibles.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        // ── Filtres personnalisés ENSPM EDT ──
        'auth'          => \App\Filters\AuthFilter::class,
        'role'          => \App\Filters\RoleFilter::class,
    ];

    /**
     * Filtres globaux (avant chaque requête).
     */
    public array $globals = [
        'before' => [
            'honeypot',
            // 'csrf', // Activez si vous utilisez des formulaires HTML
        ],
        'after' => [
            'toolbar',
            'secureheaders',
        ],
    ];

    /**
     * Filtres par méthode HTTP.
     */
    public array $methods = [];

    /**
     * Filtres par route.
     *
     * Le filtre 'auth' est appliqué sur toutes les routes protégées.
     * La route /login est exclue (pas de filtre dessus).
     */
    public array $filters = [
        'auth' => [
            'before' => [
                'dashboard',
                'dashboard/*',
                'enseignants',
                'enseignants/*',
                'cours',
                'cours/*',
                'salles',
                'salles/*',
                'filieres',
                'filieres/*',
                'edt',
                'edt/*',
                'utilisateurs',
                'utilisateurs/*',
                'historique',
                'statistiques',
                'mon-planning',
                'mes-disponibilites',
            ],
        ],
        // Exemple : restreindre une route aux admins et cd seulement
        // 'role:admin,cd' => [
        //     'before' => ['utilisateurs', 'utilisateurs/*'],
        // ],
    ];
}
