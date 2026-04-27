<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.page-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}
.page-title{font-size:1.15rem;font-weight:700;color:var(--gray-900);display:flex;align-items:center;gap:.6rem;}
.page-title svg{width:20px;height:20px;fill:var(--blue-500);}
.btn-primary-app{display:inline-flex;align-items:center;gap:.4rem;padding:.48rem 1rem;background:var(--blue-500);color:#fff;border:none;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none;cursor:pointer;transition:background .14s;}
.btn-primary-app:hover{background:var(--blue-600);color:#fff;}
.btn-primary-app svg{width:14px;height:14px;fill:#fff;}
.data-card{background:#fff;border:1px solid var(--gray-200);border-radius:10px;overflow:hidden;}
.data-table{width:100%;border-collapse:collapse;}
.data-table thead th{background:var(--gray-50);padding:.7rem 1.1rem;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--gray-500);border-bottom:1px solid var(--gray-200);text-align:left;}
.data-table tbody td{padding:.85rem 1.1rem;font-size:.855rem;color:var(--gray-900);border-bottom:1px solid var(--gray-100);vertical-align:middle;}
.data-table tbody tr:last-child td{border-bottom:none;}
.data-table tbody tr:hover td{background:var(--gray-50);}
.num-badge{display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;background:var(--blue-100);color:var(--blue-600);border-radius:6px;font-size:.72rem;font-weight:700;}
.row-name{font-weight:600;color:var(--gray-900);}
.action-wrap{display:flex;gap:.4rem;justify-content:flex-end;}
.btn-act{display:inline-flex;align-items:center;gap:.3rem;padding:.32rem .75rem;border-radius:6px;font-size:.77rem;font-weight:600;text-decoration:none;transition:all .13s;border:1px solid;}
.btn-edit-act{background:#fffbeb;color:#b45309;border-color:#fde68a;}.btn-edit-act:hover{background:#fef3c7;color:#92400e;}
.btn-del-act{background:#fef2f2;color:#b91c1c;border-color:#fecaca;}.btn-del-act:hover{background:#fee2e2;color:#991b1b;}
.btn-act svg{width:12px;height:12px;fill:currentColor;}
.empty-row td{text-align:center;padding:3rem;color:var(--gray-400);font-size:.875rem;}
</style>

<div class="page-top">
    <h1 class="page-title">
        <svg viewBox="0 0 24 24"><path d="M22 11V3h-7v3H9V3H2v8h7V8h2v10h4v3h7v-8h-7v3h-2V8h2v3h7zM7 9H4V5h3v4zm10 6h3v4h-3v-4zm0-10h3v4h-3V5z"/></svg>
        Gestion des Filières
    </h1>
    <a href="<?= base_url('/filieres/create') ?>" class="btn-primary-app">
        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Nouvelle filière
    </a>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:56px">#</th>
                <th>Filière</th>
                <th style="width:180px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($filieres)): ?>
                <tr class="empty-row"><td colspan="3">Aucune filière enregistrée</td></tr>
            <?php else: ?>
                <?php foreach($filieres as $i => $f): ?>
                <tr>
                    <td><span class="num-badge"><?= $i+1 ?></span></td>
                    <td><span class="row-name"><?= esc($f['nom']) ?></span></td>
                    <td>
                        <div class="action-wrap">
                            <a href="<?= base_url('/filieres/edit/'.$f['id']) ?>" class="btn-act btn-edit-act">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Modifier
                            </a>
                            <a href="<?= base_url('/filieres/delete/'.$f['id']) ?>" class="btn-act btn-del-act"
                               onclick="return confirm('Supprimer « <?= esc($f['nom']) ?> » ?')">
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