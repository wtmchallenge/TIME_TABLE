<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-top">
    <h1 class="page-title">
        <svg viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
        Gestion des Cours
    </h1>
    <a href="<?= base_url('/cours/create') ?>" class="btn-primary-app">
        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Nouveau cours
    </a>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Intitulé du cours</th>
                <th>Filière</th>
                <th>Volume horaire</th>
                <th style="width:190px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($cours)): ?>
                <tr class="empty-row"><td colspan="4">Aucun cours enregistré</td></tr>
            <?php else: ?>
                <?php foreach($cours as $c): ?>
                <tr>
                    <td><span class="row-name"><?= esc($c['intitule']) ?></span></td>
                    <td><span class="tag tag-blue"><?= esc($c['filiere_nom']) ?></span></td>
                    <td>
                        <span class="tag tag-gray">
                            <svg width="11" height="11" viewBox="0 0 24 24" style="fill:currentColor;vertical-align:middle;margin-right:2px"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                            <?= $c['volume_horaire'] ?>h
                        </span>
                    </td>
                    <td>
                        <div class="action-wrap">
                            <a href="<?= base_url('/cours/edit/'.$c['id']) ?>" class="btn-act btn-edit-act">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Modifier
                            </a>
                            <a href="<?= base_url('/cours/delete/'.$c['id']) ?>" class="btn-act btn-del-act"
                               onclick="return confirm('Supprimer ce cours ?')">
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