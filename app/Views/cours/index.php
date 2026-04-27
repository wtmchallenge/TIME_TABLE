<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.page-header{background:linear-gradient(135deg,#006064,#00838f);color:white;padding:2rem 2rem 1.5rem;margin:-1.5rem -1.5rem 2rem;border-radius:0 0 16px 16px;}
.page-header h2{margin:0;font-size:1.5rem;font-weight:600;}
.page-header p{margin:.25rem 0 0;opacity:.75;font-size:.9rem;}
.btn-add{background:white;color:#006064;border:none;padding:.5rem 1.25rem;border-radius:8px;font-weight:600;font-size:.875rem;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;}
.btn-add:hover{background:#e0f7fa;transform:translateY(-1px);}
.card-table{border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);border:none;}
.card-table thead th{background:#e0f7fa;color:#006064;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;border:none;padding:1rem 1.25rem;}
.card-table tbody td{padding:.9rem 1.25rem;vertical-align:middle;border-color:#e0f7fa;}
.card-table tbody tr:hover{background:#f0fdff;}
.filiere-tag{background:#b2ebf2;color:#006064;padding:.2rem .75rem;border-radius:20px;font-size:.78rem;font-weight:600;}
.heures-badge{background:#e0f7fa;color:#00838f;padding:.25rem .75rem;border-radius:8px;font-size:.85rem;font-weight:600;}
.action-btn{padding:.35rem .85rem;border-radius:6px;font-size:.8rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .15s;}
.btn-edit{background:#fff8e1;color:#f57f17;border:1px solid #ffe082;}.btn-edit:hover{background:#fff3cd;color:#e65100;}
.btn-del{background:#ffebee;color:#c62828;border:1px solid #ffcdd2;}.btn-del:hover{background:#ffcdd2;color:#b71c1c;}
.empty-state{text-align:center;padding:3rem;color:#9e9e9e;}
</style>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>📖 Gestion des Cours</h2>
        <p>Département INFOTEL — ENSPM</p>
    </div>
    <a href="/cours/create" class="btn-add">+ Nouveau cours</a>
</div>

<?php if(session('success')): ?>
    <div class="alert border-0 rounded-3 mb-3" style="background:#e8f5e9;color:#2e7d32;">✅ <?= session('success') ?></div>
<?php endif; ?>

<div class="card card-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Intitulé du cours</th>
                <th>Filière</th>
                <th>Volume horaire</th>
                <th style="width:180px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($cours)): ?>
                <tr><td colspan="4"><div class="empty-state"><div style="font-size:3rem">📖</div><p style="font-weight:600;color:#555;margin:0">Aucun cours enregistré</p></div></td></tr>
            <?php else: ?>
                <?php foreach($cours as $c): ?>
                <tr>
                    <td style="font-weight:500;color:#006064"><?= esc($c['intitule']) ?></td>
                    <td><span class="filiere-tag"><?= esc($c['filiere_nom']) ?></span></td>
                    <td><span class="heures-badge">⏱ <?= $c['volume_horaire'] ?>h</span></td>
                    <td style="text-align:right">
                        <a href="/cours/edit/<?= $c['id'] ?>" class="action-btn btn-edit">✏️ Modifier</a>
                        <a href="/cours/delete/<?= $c['id'] ?>" class="action-btn btn-del ms-1"
                           onclick="return confirm('Supprimer ce cours ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>