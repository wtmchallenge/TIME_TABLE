<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div style="padding: 0.5rem 0 1.5rem;">
    <h1 style="font-size:1.5rem; font-weight:700; color:#1f2937;">
        Bonjour, <?= esc(session()->get('user_prenom')) ?> 👋
    </h1>
    <p style="color:#6b7280; margin-top:0.25rem;">
        Bienvenue sur la plateforme de gestion des emplois du temps — ENSPM INFOTEL
    </p>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:1rem;">
    <!-- Carte exemple -->
    <div style="background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); border-left:4px solid #1a6b3a;">
        <div style="font-size:1.8rem;">👨‍🏫</div>
        <div style="font-size:1.5rem; font-weight:700; margin-top:0.5rem;">—</div>
        <div style="font-size:0.82rem; color:#6b7280; margin-top:0.25rem;">Enseignants</div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); border-left:4px solid #6a0dad;">
        <div style="font-size:1.8rem;">📚</div>
        <div style="font-size:1.5rem; font-weight:700; margin-top:0.5rem;">—</div>
        <div style="font-size:0.82rem; color:#6b7280; margin-top:0.25rem;">Cours</div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); border-left:4px solid #c8952a;">
        <div style="font-size:1.8rem;">🏫</div>
        <div style="font-size:1.5rem; font-weight:700; margin-top:0.5rem;">—</div>
        <div style="font-size:0.82rem; color:#6b7280; margin-top:0.25rem;">Salles</div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); border-left:4px solid #3b82f6;">
        <div style="font-size:1.8rem;">🗓️</div>
        <div style="font-size:1.5rem; font-weight:700; margin-top:0.5rem;">—</div>
        <div style="font-size:0.82rem; color:#6b7280; margin-top:0.25rem;">Créneaux planifiés</div>
    </div>
</div>

<div style="margin-top:1.5rem; background:#fff; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
    <h2 style="font-size:1rem; font-weight:600; color:#374151; margin-bottom:1rem;">🚀 Module 1 — Authentification</h2>
    <p style="font-size:0.875rem; color:#6b7280;">
        Le module d'authentification est opérationnel. Les prochains modules (Ressources, EDT, Dashboard) seront accessibles depuis le menu latéral.
    </p>
</div>

<?php $this->endSection(); ?>
