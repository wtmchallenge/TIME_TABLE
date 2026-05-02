<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.jour-pill{display:inline-block;padding:.18rem .65rem;border-radius:5px;font-size:.77rem;font-weight:700;}
.j-Lundi{background:#eff6ff;color:#1d4ed8;} .j-Mardi{background:#f5f3ff;color:#6d28d9;}
.j-Mercredi{background:#f0fdf4;color:#15803d;} .j-Jeudi{background:#fffbeb;color:#b45309;}
.j-Vendredi{background:#fdf2f8;color:#9d174d;} .j-Samedi{background:#ecfdf5;color:#065f46;}
</style>

<div class="page-top">
    <h1 class="page-title">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-8 9z"/></svg>
        Disponibilités des enseignants
    </h1>
    <a href="<?= base_url('/disponibilites/create') ?>" class="btn-primary-app">
        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Ajouter
    </a>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Enseignant</th>
                <th>Jour</th>
                <th>Créneau</th>
                <th style="width:190px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($disponibilites)): ?>
                <tr class="empty-row"><td colspan="4">Aucune disponibilité enregistrée</td></tr>
            <?php else: ?>
                <?php foreach($disponibilites as $d): ?>
                <tr>
                    <td><span class="row-name"><?= esc($d['prenom'].' '.$d['nom']) ?></span></td>
                    <td><span class="jour-pill j-<?= $d['jour'] ?>"><?= $d['jour'] ?></span></td>
                    <td><span class="mono-time"><?= substr($d['heure_debut'],0,5) ?> → <?= substr($d['heure_fin'],0,5) ?></span></td>
                    <td>
                        <div class="action-wrap">
                            <a href="<?= base_url('/disponibilites/edit/'.$d['id']) ?>" class="btn-act btn-edit-act">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Modifier
                            </a>
                            <a href="<?= base_url('/disponibilites/delete/'.$d['id']) ?>" class="btn-act btn-del-act"
                               onclick="return confirm('Supprimer cette disponibilité ?')">
                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                Supprimer
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>