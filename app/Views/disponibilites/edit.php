<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.back-btn{display:inline-flex;align-items:center;gap:5px;color:#5c6bc0;text-decoration:none;font-size:.875rem;padding:.4rem .75rem;border-radius:8px;border:1px solid #c5cae9;transition:all .15s;}.back-btn:hover{background:#e8eaf6;}
.form-card{max-width:560px;margin:0 auto;background:white;border-radius:16px;box-shadow:0 4px 24px rgba(26,35,126,.1);overflow:hidden;}
.form-card-header{background:linear-gradient(135deg,#e65100,#f57c00);padding:1.5rem 2rem;color:white;}
.form-card-header h4{margin:0;font-size:1.15rem;font-weight:600;}
.form-card-header p{margin:.25rem 0 0;opacity:.8;font-size:.85rem;}
.form-card-body{padding:2rem;}
.lbl{font-size:.8rem;font-weight:700;color:#e65100;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:.4rem;}
.inp,.sel{border:1.5px solid #ffe0b2;border-radius:10px;padding:.7rem 1rem;font-size:.95rem;width:100%;transition:all .2s;box-sizing:border-box;background:white;}
.inp:focus,.sel:focus{border-color:#f57c00;box-shadow:0 0 0 3px rgba(245,124,0,.12);outline:none;}
.btn-submit{background:linear-gradient(135deg,#e65100,#f57c00);color:white;border:none;padding:.75rem 2rem;border-radius:10px;font-weight:600;font-size:.9rem;cursor:pointer;transition:all .2s;}
.btn-submit:hover{transform:translateY(-1px);}
.btn-cancel{color:#757575;text-decoration:none;padding:.75rem 1.25rem;border-radius:10px;border:1px solid #e0e0e0;font-size:.9rem;}
.btn-cancel:hover{background:#f5f5f5;}
</style>

<div class="mb-3 d-flex align-items-center gap-2">
    <a href="/disponibilites" class="back-btn">← Retour</a>
    <span style="color:#9e9e9e;font-size:.85rem">/ Modifier disponibilité</span>
</div>

<div class="form-card">
    <div class="form-card-header">
        <h4>✏️ Modifier la disponibilité</h4>
        <p>ID #<?= $dispo['id'] ?></p>
    </div>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="rounded-3 p-3 mb-3" style="background:#ffebee;color:#c62828;font-size:.875rem">
                <?php foreach(session('errors') as $err): ?><div>⚠️ <?= $err ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="/disponibilites/update/<?= $dispo['id'] ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="lbl">Enseignant</label>
                <select name="enseignant_id" class="sel">
                    <?php foreach($enseignants as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= (old('enseignant_id',$dispo['enseignant_id'])==$e['id'])? 'selected':'' ?>>
                            <?= esc($e['prenom'].' '.$e['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="lbl">Jour</label>
                <select name="jour" class="sel">
                    <?php foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j): ?>
                        <option value="<?= $j ?>" <?= (old('jour',$dispo['jour'])==$j)? 'selected':'' ?>><?= $j ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="lbl">Heure de début</label>
                    <input type="time" name="heure_debut" class="inp" value="<?= old('heure_debut',$dispo['heure_debut']) ?>">
                </div>
                <div class="col-6">
                    <label class="lbl">Heure de fin</label>
                    <input type="time" name="heure_fin" class="inp" value="<?= old('heure_fin',$dispo['heure_fin']) ?>">
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #fff3e0">
                <a href="/disponibilites" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">💾 Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>