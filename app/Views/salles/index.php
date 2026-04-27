<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.page-header{background:linear-gradient(135deg,#4a148c,#6a1b9a);color:white;padding:2rem 2rem 1.5rem;margin:-1.5rem -1.5rem 2rem;border-radius:0 0 16px 16px;}
.page-header h2{margin:0;font-size:1.5rem;font-weight:600;}
.page-header p{margin:.25rem 0 0;opacity:.75;font-size:.9rem;}
.btn-add{background:white;color:#4a148c;border:none;padding:.5rem 1.25rem;border-radius:8px;font-weight:600;font-size:.875rem;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;}
.btn-add:hover{background:#f3e5f5;transform:translateY(-1px);}
.card-table{border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);border:none;}
.card-table thead th{background:#f3e5f5;color:#6a1b9a;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;border:none;padding:1rem 1.25rem;}
.card-table tbody td{padding:.9rem 1.25rem;vertical-align:middle;border-color:#f9f0ff;}
.card-table tbody tr:hover{background:#fce4ec;}
.capacite-badge{background:#ede7f6;color:#4a148c;padding:.25rem .85rem;border-radius:20px;font-size:.85rem;font-weight:600;}
.action-btn{padding:.35rem .85rem;border-radius:6px;font-size:.8rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .15s;}
.btn-edit{background:#fff8e1;color:#f57f17;border:1px solid #ffe082;}.btn-edit:hover{background:#fff3cd;color:#e65100;}
.btn-del{background:#ffebee;color:#c62828;border:1px solid #ffcdd2;}.btn-del:hover{background:#ffcdd2;color:#b71c1c;}
.salle-icon{width:36px;height:36px;background:#ede7f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
.empty-state{text-align:center;padding:3rem;color:#9e9e9e;}
</style>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>🏫 Gestion des Salles</h2>
        <p>Département INFOTEL — ENSPM</p>
    </div>
    <a href="/salles/create" class="btn-add">+ Nouvelle salle</a>
</div>

<?php if(session('success')): ?>
    <div class="alert border-0 rounded-3 mb-3" style="background:#e8f5e9;color:#2e7d32;">✅ <?= session('success') ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert border-0 rounded-3 mb-3" style="background:#ffebee;color:#c62828;">⚠️ <?= session('error') ?></div>
<?php endif; ?>

<div class="card card-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th style="width:56px"></th>
                <th>Nom de la salle</th>
                <th>Capacité</th>
                <th style="width:180px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($salles)): ?>
                <tr><td colspan="4"><div class="empty-state"><div style="font-size:3rem">🏫</div><p style="font-weight:600;color:#555;margin:0">Aucune salle enregistrée</p></div></td></tr>
            <?php else: ?>
                <?php foreach($salles as $s): ?>
                <tr>
                    <td><div class="salle-icon">🚪</div></td>
                    <td style="font-weight:500;color:#4a148c"><?= esc($s['nom']) ?></td>
                    <td><span class="capacite-badge"><?= $s['capacite'] ?> places</span></td>
                    <td style="text-align:right">
                        <a href="/salles/edit/<?= $s['id'] ?>" class="action-btn btn-edit">✏️ Modifier</a>
                        <a href="/salles/delete/<?= $s['id'] ?>" class="action-btn btn-del ms-1"
                           onclick="return confirm('Supprimer la salle <?= esc($s['nom']) ?> ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>