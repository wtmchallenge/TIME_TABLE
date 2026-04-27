<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('/disponibilites') ?>" class="back-link">
    <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    Retour aux disponibilités
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24" style="fill:#b45309"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
        <h2>Modifier la disponibilité</h2>
    </div>
    <form action="<?= base_url('/disponibilites/update/'.$dispo['id']) ?>" method="POST" id="frm">
    <?= csrf_field() ?>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="err-box"><?php foreach(session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="f-label">Enseignant</label>
            <select name="enseignant_id" class="f-select">
                <?php foreach($enseignants as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= (old('enseignant_id',$dispo['enseignant_id'])==$e['id'])?'selected':'' ?>>
                        <?= esc($e['prenom'].' '.$e['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="f-label">Jour</label>
            <select name="jour" class="f-select">
                <?php foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j): ?>
                    <option value="<?= $j ?>" <?= (old('jour',$dispo['jour'])==$j)?'selected':'' ?>><?= $j ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row-2col">
            <div>
                <label class="f-label">Heure de début</label>
                <input type="time" name="heure_debut" class="f-input" value="<?= old('heure_debut',$dispo['heure_debut']) ?>">
            </div>
            <div>
                <label class="f-label">Heure de fin</label>
                <input type="time" name="heure_fin" class="f-input" value="<?= old('heure_fin',$dispo['heure_fin']) ?>">
            </div>
        </div>
    </div>
    <div class="form-card-foot">
        <a href="<?= base_url('/disponibilites') ?>" class="btn-cancel-app">Annuler</a>
        <button type="submit" class="btn-submit-app">
            <svg viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
            Enregistrer
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>