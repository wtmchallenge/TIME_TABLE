<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-top">
    <h1 class="page-title">
        <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
        Gestion des Salles
    </h1>
    <a href="<?= base_url('/salles/create') ?>" class="btn-primary-app">
        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Nouvelle salle
    </a>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:50px"></th>
                <th>Nom de la salle</th>
                <th>Capacité</th>
                <th style="width:190px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($salles)): ?>
                <tr class="empty-row"><td colspan="4">Aucune salle enregistrée</td></tr>
            <?php else: ?>
                <?php foreach($salles as $s): ?>
                <tr>
                    <td>
                        <div style="width:34px;height:34px;background:var(--gray-100);border-radius:7px;display:flex;align-items:center;justify-content:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" style="fill:var(--gray-500)"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                        </div>
                    </td>
                    <td><span class="row-name"><?= esc($s['nom']) ?></span></td>
                    <td><span class="tag tag-gray"><?= $s['capacite'] ?> places</span></td>
                    <td>
                        <div class="action-wrap">
                            <a href="<?= base_url('/salles/edit/'.$s['id']) ?>" class="btn-act btn-edit-act">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Modifier
                            </a>
                            <a href="<?= base_url('/salles/delete/'.$s['id']) ?>" class="btn-act btn-del-act"
                               onclick="return confirm('Supprimer la salle <?= esc($s['nom']) ?> ?')">
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