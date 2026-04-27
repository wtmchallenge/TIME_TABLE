<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.page-header {
    background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
    color: white;
    padding: 2rem 2rem 1.5rem;
    margin: -1.5rem -1.5rem 2rem;
    border-radius: 0 0 16px 16px;
}
.page-header h2 { margin: 0; font-size: 1.5rem; font-weight: 600; }
.page-header p  { margin: 0.25rem 0 0; opacity: 0.75; font-size: 0.9rem; }
.btn-add {
    background: white; color: #1a237e; border: none;
    padding: 0.5rem 1.25rem; border-radius: 8px;
    font-weight: 600; font-size: 0.875rem;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: all 0.2s;
}
.btn-add:hover { background: #e8eaf6; color: #1a237e; transform: translateY(-1px); }
.card-table { border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); border: none; }
.card-table .table { margin: 0; }
.card-table thead th {
    background: #f8f9ff; color: #3949ab;
    font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; border: none; padding: 1rem 1.25rem;
}
.card-table tbody td { padding: 0.9rem 1.25rem; vertical-align: middle; border-color: #f0f0f7; }
.card-table tbody tr:hover { background: #f8f9ff; }
.filiere-name { font-weight: 500; color: #1a237e; }
.filiere-badge {
    display: inline-block; background: #e8eaf6; color: #3949ab;
    padding: 0.2rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;
}
.action-btn {
    padding: 0.35rem 0.85rem; border-radius: 6px; font-size: 0.8rem;
    font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    transition: all 0.15s;
}
.action-btn-edit  { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; }
.action-btn-edit:hover  { background: #fff3cd; color: #e65100; }
.action-btn-del   { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
.action-btn-del:hover   { background: #ffcdd2; color: #b71c1c; }
.empty-state { text-align: center; padding: 3rem; color: #9e9e9e; }
.empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
</style>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>📚 Gestion des Filières</h2>
        <p>Département INFOTEL — ENSPM</p>
    </div>
    <a href="/filieres/create" class="btn-add">
        <span style="font-size:1.1rem">+</span> Nouvelle filière
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 border-0 shadow-sm mb-3" style="background:#e8f5e9;color:#2e7d32;">
        <span>✅</span> <?= session('success') ?>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 border-0 shadow-sm mb-3" style="background:#ffebee;color:#c62828;">
        <span>⚠️</span> <?= session('error') ?>
    </div>
<?php endif; ?>

<div class="card card-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th style="width:60px">#</th>
                <th>Filière</th>
                <th style="width:180px; text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($filieres)): ?>
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div style="font-size:3rem">🎓</div>
                            <p style="font-weight:600;color:#555;margin:0">Aucune filière enregistrée</p>
                            <p style="font-size:0.875rem">Ajoutez la première filière du département</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($filieres as $i => $filiere): ?>
                <tr>
                    <td><span class="filiere-badge"><?= $i + 1 ?></span></td>
                    <td><span class="filiere-name"><?= esc($filiere['nom']) ?></span></td>
                    <td style="text-align:right">
                        <a href="/filieres/edit/<?= $filiere['id'] ?>" class="action-btn action-btn-edit">
                            ✏️ Modifier
                        </a>
                        <a href="/filieres/delete/<?= $filiere['id'] ?>"
                           class="action-btn action-btn-del ms-1"
                           onclick="return confirm('Supprimer la filière « <?= esc($filiere['nom']) ?> » ?')">
                            🗑️ Supprimer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>