<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('/enseignants') ?>" class="back-link">
    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    Retour aux enseignants
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        <h2>Ajouter un enseignant</h2>
    </div>
    <form action="<?= base_url('/enseignants/store') ?>" method="POST" id="frm">
    <?= csrf_field() ?>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="err-box"><?php foreach(session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?></div>
        <?php endif; ?>
        <div class="row-2col mb-3">
            <div>
                <label class="f-label">Prénom</label>
                <input type="text" name="prenom" class="f-input" value="<?= old('prenom') ?>" placeholder="Jean" autofocus>
            </div>
            <div>
                <label class="f-label">Nom</label>
                <input type="text" name="nom" class="f-input" value="<?= old('nom') ?>" placeholder="Dupont">
            </div>
        </div>
        <div class="mb-3">
            <label class="f-label">Email</label>
            <input type="email" name="email" class="f-input" value="<?= old('email') ?>" placeholder="j.dupont@enspm.cm">
        </div>
        <div>
            <label class="f-label">Spécialité</label>
            <input type="text" name="specialite" class="f-input" value="<?= old('specialite') ?>" placeholder="Ex : Réseaux et Télécommunications">
        </div>
    </div>
    <div class="form-card-foot">
        <a href="<?= base_url('/enseignants') ?>" class="btn-cancel-app">Annuler</a>
        <button type="submit" class="btn-submit-app">
            <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
            Enregistrer
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>