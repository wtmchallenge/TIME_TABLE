<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.form-page-header {
    display: flex; align-items: center; gap: 0.75rem;
    margin-bottom: 2rem;
}
.back-btn {
    display: inline-flex; align-items: center; gap: 5px;
    color: #5c6bc0; text-decoration: none; font-size: 0.875rem;
    padding: 0.4rem 0.75rem; border-radius: 8px;
    border: 1px solid #c5cae9; transition: all 0.15s;
}
.back-btn:hover { background: #e8eaf6; color: #3949ab; }
.form-card {
    max-width: 560px; margin: 0 auto;
    background: white; border-radius: 16px;
    box-shadow: 0 4px 24px rgba(26,35,126,0.1);
    overflow: hidden;
}
.form-card-header {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    padding: 1.5rem 2rem; color: white;
}
.form-card-header h4 { margin: 0; font-size: 1.15rem; font-weight: 600; }
.form-card-header p  { margin: 0.25rem 0 0; opacity: 0.75; font-size: 0.85rem; }
.form-card-body { padding: 2rem; }
.form-label-custom {
    font-size: 0.82rem; font-weight: 700; color: #3949ab;
    text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;
}
.form-control-custom {
    border: 1.5px solid #c5cae9; border-radius: 10px;
    padding: 0.75rem 1rem; font-size: 0.95rem; transition: all 0.2s;
}
.form-control-custom:focus {
    border-color: #3949ab; box-shadow: 0 0 0 3px rgba(57,73,171,0.12);
    outline: none;
}
.btn-submit {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    color: white; border: none; padding: 0.75rem 2rem;
    border-radius: 10px; font-weight: 600; font-size: 0.9rem;
    cursor: pointer; transition: all 0.2s;
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(26,35,126,0.3); }
.btn-cancel-custom {
    color: #757575; text-decoration: none; padding: 0.75rem 1.25rem;
    border-radius: 10px; border: 1px solid #e0e0e0;
    font-size: 0.9rem; transition: all 0.15s;
}
.btn-cancel-custom:hover { background: #f5f5f5; color: #424242; }
</style>

<div class="form-page-header">
    <a href="/filieres" class="back-btn">← Retour</a>
    <span style="color:#9e9e9e;font-size:0.85rem">/ Nouvelle filière</span>
</div>

<div class="form-card">
    <div class="form-card-header">
        <h4>🎓 Ajouter une filière</h4>
        <p>Département INFOTEL — ENSPM</p>
    </div>
    <div class="form-card-body">

        <?php if(session('errors')): ?>
            <div class="alert rounded-3 border-0 mb-3" style="background:#ffebee;color:#c62828;font-size:0.875rem">
                <?php foreach(session('errors') as $error): ?>
                    <div>⚠️ <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/filieres/store" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label-custom d-block">Nom de la filière</label>
                <input type="text"
                       name="nom"
                       class="form-control form-control-custom w-100"
                       value="<?= old('nom') ?>"
                       placeholder="Ex: Informatique et Télécommunications"
                       autofocus>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #f0f0f7">
                <a href="/filieres" class="btn-cancel-custom">Annuler</a>
                <button type="submit" class="btn-submit">✓ Enregistrer</button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>