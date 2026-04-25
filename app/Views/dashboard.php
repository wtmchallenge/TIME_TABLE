<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<!-- En-tête -->
<div class="mb-4">
    <h1 style="font-size:1.4rem;font-weight:700;color:#0f172a;margin-bottom:4px;">
        Bonjour, <?= esc(session()->get('user_prenom')) ?>
    </h1>
    <p style="font-size:0.875rem;color:#6b7280;margin:0;">
        Bienvenue sur la plateforme de gestion des emplois du temps — ENSPM INFOTEL
    </p>
</div>

<!-- Cartes statistiques -->
<div class="row g-3 mb-4">

    <!-- Enseignants -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:42px;height:42px;border-radius:10px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#16a34a"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            </div>
            <div>
                <div style="font-size:1.35rem;font-weight:700;color:#0f172a;line-height:1;">—</div>
                <div style="font-size:0.78rem;color:#6b7280;margin-top:3px;">Enseignants</div>
            </div>
        </div>
    </div>

    <!-- Cours -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:42px;height:42px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#dc2626"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
            </div>
            <div>
                <div style="font-size:1.35rem;font-weight:700;color:#0f172a;line-height:1;">—</div>
                <div style="font-size:0.78rem;color:#6b7280;margin-top:3px;">Cours</div>
            </div>
        </div>
    </div>

    <!-- Salles -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:42px;height:42px;border-radius:10px;background:#fffbeb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#d97706"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
            </div>
            <div>
                <div style="font-size:1.35rem;font-weight:700;color:#0f172a;line-height:1;">—</div>
                <div style="font-size:0.78rem;color:#6b7280;margin-top:3px;">Salles</div>
            </div>
        </div>
    </div>

    <!-- Créneaux -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:42px;height:42px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#2563eb"><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>
            </div>
            <div>
                <div style="font-size:1.35rem;font-weight:700;color:#0f172a;line-height:1;">—</div>
                <div style="font-size:0.78rem;color:#6b7280;margin-top:3px;">Créneaux planifiés</div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection(); ?>
