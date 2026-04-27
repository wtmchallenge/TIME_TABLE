<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* Réutilise les mêmes styles que create.php — idéalement ces styles
   sont dans un fichier CSS commun assets/css/forms.css */
.form-page-header { display:flex; align-items:center; gap:0.75rem; margin-bottom:2rem; }
.back-btn { display:inline-flex;align-items:center;gap:5px;color:#5c6bc0;text-decoration:none;font-size:0.875rem;padding:0.4rem 0.75rem;border-radius:8px;border:1px solid #c5cae9;transition:all 0.15s; }
.back-btn:hover { background:#e8eaf6;color:#3949ab; }
.form-card { max-width:560px;margin:0 auto;background:white;border-radius:16px;box-shadow:0 4px 24px rgba(26,35,126,0.1);overflow:hidden; }
.form-card-header-edit { background:linear-gradient(135deg,#e65100,#f57c00);padding:1.5rem 2rem;color:white; }
.form-card-header-edit h4 { margin:0;font-size:1.15rem;font-weight:600; }
.form-card-header-edit p  { margin:0.25rem 0 0;opacity:0.8;font-size:0.85rem; }
.form-card-body { padding:2rem; }
.form-label-custom { font-size:0.82rem;font-weight:700;color:#e65100;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem; }
.form-control-custom { border:1.5px solid #ffe0b2;border-radius:10px;padding:0.75rem 1rem;font-size:0.95rem;transition:all 0.2s; }
.form-control-custom:focus { border-color:#f57c00;box-shadow:0 0 0 3px rgba(245,124,0,0.12);outline:none; }
.current-value { background:#fff8e1;border-radius:8px;padding:0.6rem 1rem;font-size:0.85rem;color:#795548;margin-bottom:1rem;border:1px solid #ffe082; }
.btn-edit-submit { background:linear-gradient(135deg,#e65100,#f57c00);color:white;border:none;padding:0.75rem 2rem;border-radius:10px;font-weight:600;font-size:0.9rem;cursor:pointer;transition:all 0.2s; }
.btn-edit-submit:hover { transform:translateY(-1px);box-shadow:0 4px 12px rgba(230,81,0,0.3); }
.btn-cancel-custom { color:#757575;text-decoration:none;padding:0.75rem 1.25rem;border-radius:10px;border:1px solid #e0e0e0;font-size:0.9rem;transition:all 0.15s; }
.btn-cancel-custom:hover { background:#f5f5f5;color:#424242; }
</style>

<div class="form-page-header">
    <a href="/filieres" class="back-btn">← Retour</a>
    <span style="color:#9e9e9e;font-size:0.85rem">/ Modifier filière</span>
</div>

<div class="form-card">
    <div class="form-card-header-edit">
        <h4>✏️ Modifier la filière</h4>
        <p>ID #<?= $filiere['id'] ?> — Département INFOTEL</p>
    </div>
    <div class="form-card-body">

        <?php if(session('errors')): ?>
            <div class="alert rounded-3 border-0 mb-3" style="background:#ffebee;color:#c62828;font-size:0.875rem">
                <?php foreach(session('errors') as $error): ?>
                    <div>⚠️ <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="current-value">
            📌 Valeur actuelle : <strong><?= esc($filiere['nom']) ?></strong>
        </div>

        <form action="/filieres/update/<?= $filiere['id'] ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label-custom d-block">Nouveau nom</label>
                <input type="text"
                       name="nom"
                       class="form-control form-control-custom w-100"
                       value="<?= old('nom', $filiere['nom']) ?>"
                       autofocus>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #fff3e0">
                <a href="/filieres" class="btn-cancel-custom">Annuler</a>
                <button type="submit" class="btn-edit-submit">💾 Enregistrer les modifications</button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>