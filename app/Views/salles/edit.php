<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('/salles') ?>" class="back-link">
    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    Retour aux salles
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24" style="fill:#b45309"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
        <h2>Modifier la salle</h2>
    </div>
    <form action="<?= base_url('/salles/update/'.$salle['id']) ?>" method="POST" id="frm">
    <?= csrf_field() ?>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="err-box"><?php foreach(session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?></div>
        <?php endif; ?>
        <div class="current-val">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            Actuel : <strong><?= esc($salle['nom']) ?></strong> — <?= $salle['capacite'] ?> places
        </div>
        <div class="mb-3">
            <label class="f-label">Nom de la salle</label>
            <input type="text" name="nom" class="f-input" value="<?= old('nom',$salle['nom']) ?>">
        </div>
        <div>
            <label class="f-label">Capacité (places)</label>
            <input type="number" name="capacite" class="f-input" value="<?= old('capacite',$salle['capacite']) ?>" min="1">
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