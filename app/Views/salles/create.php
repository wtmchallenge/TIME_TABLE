<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('/salles') ?>" class="back-link">
    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    Retour aux salles
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm4 0H8v-2h2v2zm10 0h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10z"/></svg>
        <h2>Ajouter une salle</h2>
    </div>
    <form action="<?= base_url('/salles/store') ?>" method="POST" id="frm">
    <?= csrf_field() ?>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="err-box"><?php foreach(session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="f-label">Nom de la salle</label>
            <input type="text" name="nom" class="f-input" value="<?= old('nom') ?>" placeholder="Ex : Labo INFOTEL" autofocus>
        </div>
        <div>
            <label class="f-label">Capacité (nombre de places)</label>
            <input type="number" name="capacite" class="f-input" value="<?= old('capacite') ?>" placeholder="Ex : 30" min="1">
        </div>
    </div>
    <div class="form-card-foot">
        <a href="<?= base_url('/salles') ?>" class="btn-cancel-app">Annuler</a>
        <button type="submit" class="btn-submit-app">
            <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
            Enregistrer
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>