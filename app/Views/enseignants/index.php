<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-top">
    <h1 class="page-title">
        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        Gestion des Enseignants
    </h1>
    <a href="<?= base_url('/enseignants/create') ?>" class="btn-primary-app">
        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Nouvel enseignant
    </a>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:50px"></th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Spécialité</th>
                <th style="width:190px;text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($enseignants)): ?>
                <tr class="empty-row"><td colspan="5">Aucun enseignant enregistré</td></tr>
            <?php else: ?>
                <?php foreach($enseignants as $e): ?>
                <tr>
                    <td>
                        <div class="avatar-circle">
                            <?= strtoupper(substr($e['prenom'],0,1).substr($e['nom'],0,1)) ?>
                        </div>
                    </td>
                    <td><span class="row-name"><?= esc($e['prenom'].' '.$e['nom']) ?></span></td>
                    <td style="color:var(--gray-500);font-size:.82rem"><?= esc($e['email']) ?></td>
                    <td><span class="tag tag-blue"><?= esc($e['specialite']) ?></span></td>
                    <td>
                        <div class="action-wrap">
                            <a href="<?= base_url('/enseignants/edit/'.$e['id']) ?>" class="btn-act btn-edit-act">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Modifier
                            </a>
                            <a href="<?= base_url('/enseignants/delete/'.$e['id']) ?>" class="btn-act btn-del-act"
                               onclick="return confirm('Supprimer <?= esc($e['prenom'].' '.$e['nom']) ?> ?')">
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