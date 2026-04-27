<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('/cours') ?>" class="back-link">
    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    Retour aux cours
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
        <h2>Ajouter un cours</h2>
    </div>
    <form action="<?= base_url('/cours/store') ?>" method="POST" id="frm">
    <?= csrf_field() ?>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="err-box"><?php foreach(session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="f-label">Intitulé du cours</label>
            <input type="text" name="intitule" class="f-input" value="<?= old('intitule') ?>" placeholder="Ex : Développement Web" autofocus>
        </div>
        <div class="mb-3">
            <label class="f-label">Filière</label>
            <select name="filiere_id" class="f-select">
                <option value="">— Choisir une filière —</option>
                <?php foreach($filieres as $f): ?>
                    <option value="<?= $f['id'] ?>" <?= old('filiere_id')==$f['id']?'selected':'' ?>><?= esc($f['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="f-label">Volume horaire total (heures)</label>
            <input type="number" name="volume_horaire" class="f-input" value="<?= old('volume_horaire') ?>" placeholder="Ex : 90" min="1">
        </div>
    </div>
    <div class="form-card-foot">
        <a href="<?= base_url('/cours') ?>" class="btn-cancel-app">Annuler</a>
        <button type="submit" class="btn-submit-app">
            <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
            Enregistrer
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>