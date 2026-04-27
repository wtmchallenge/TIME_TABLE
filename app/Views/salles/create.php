<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.back-btn{display:inline-flex;align-items:center;gap:5px;color:#6a1b9a;text-decoration:none;font-size:.875rem;padding:.4rem .75rem;border-radius:8px;border:1px solid #ce93d8;transition:all .15s;}.back-btn:hover{background:#f3e5f5;}
.form-card{max-width:500px;margin:0 auto;background:white;border-radius:16px;box-shadow:0 4px 24px rgba(74,20,140,.1);overflow:hidden;}
.form-card-header{background:linear-gradient(135deg,#4a148c,#6a1b9a);padding:1.5rem 2rem;color:white;}
.form-card-header h4{margin:0;font-size:1.15rem;font-weight:600;}
.form-card-header p{margin:.25rem 0 0;opacity:.75;font-size:.85rem;}
.form-card-body{padding:2rem;}
.lbl{font-size:.8rem;font-weight:700;color:#6a1b9a;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:.4rem;}
.inp{border:1.5px solid #e1bee7;border-radius:10px;padding:.7rem 1rem;font-size:.95rem;width:100%;transition:all .2s;box-sizing:border-box;}
.inp:focus{border-color:#6a1b9a;box-shadow:0 0 0 3px rgba(106,27,154,.12);outline:none;}
.btn-submit{background:linear-gradient(135deg,#4a148c,#6a1b9a);color:white;border:none;padding:.75rem 2rem;border-radius:10px;font-weight:600;font-size:.9rem;cursor:pointer;transition:all .2s;}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(74,20,140,.3);}
.btn-cancel{color:#757575;text-decoration:none;padding:.75rem 1.25rem;border-radius:10px;border:1px solid #e0e0e0;font-size:.9rem;}
.btn-cancel:hover{background:#f5f5f5;}
</style>

<div class="mb-3 d-flex align-items-center gap-2">
    <a href="/salles" class="back-btn">← Retour</a>
    <span style="color:#9e9e9e;font-size:.85rem">/ Nouvelle salle</span>
</div>

<div class="form-card">
    <div class="form-card-header">
        <h4>🏫 Ajouter une salle</h4>
        <p>Département INFOTEL — ENSPM</p>
    </div>
    <div class="form-card-body">
        <?php if(session('errors')): ?>
            <div class="rounded-3 p-3 mb-3" style="background:#ffebee;color:#c62828;font-size:.875rem">
                <?php foreach(session('errors') as $err): ?><div>⚠️ <?= $err ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="/salles/store" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="lbl">Nom de la salle</label>
                <input type="text" name="nom" class="inp" value="<?= old('nom') ?>" placeholder="Ex: Labo INFOTEL" autofocus>
            </div>
            <div class="mb-4">
                <label class="lbl">Capacité (nombre de places)</label>
                <input type="number" name="capacite" class="inp" value="<?= old('capacite') ?>" placeholder="Ex: 30" min="1">
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #f3e5f5">
                <a href="/salles" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">✓ Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>