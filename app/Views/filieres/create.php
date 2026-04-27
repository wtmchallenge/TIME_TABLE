<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .8rem;
        color: var(--gray-500);
        text-decoration: none;
        margin-bottom: 1.25rem;
        transition: color .13s;
    }

    .back-link:hover {
        color: var(--blue-500);
    }

    .back-link svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }

    .form-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 10px;
        max-width: 520px;
    }

    .form-card-head {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .form-card-head svg {
        width: 18px;
        height: 18px;
        fill: var(--blue-500);
    }

    .form-card-head h2 {
        font-size: .97rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .form-card-body {
        padding: 1.5rem;
    }

    .f-label {
        display: block;
        font-size: .75rem;
        font-weight: 700;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .45rem;
    }

    .f-input {
        width: 100%;
        padding: .6rem .875rem;
        border: 1px solid var(--gray-300);
        border-radius: 7px;
        font-size: .875rem;
        color: var(--gray-900);
        font-family: inherit;
        transition: border-color .13s, box-shadow .13s;
        box-sizing: border-box;
    }

    .f-input:focus {
        outline: none;
        border-color: var(--blue-400);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .form-card-foot {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-cancel-app {
        display: inline-flex;
        align-items: center;
        padding: .45rem .9rem;
        background: none;
        border: 1px solid var(--gray-200);
        border-radius: 7px;
        font-size: .82rem;
        font-weight: 500;
        color: var(--gray-600);
        text-decoration: none;
        transition: all .13s;
    }

    .btn-cancel-app:hover {
        background: var(--gray-100);
        color: var(--gray-900);
    }

    .btn-submit-app {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem 1.1rem;
        background: var(--blue-500);
        color: #fff;
        border: none;
        border-radius: 7px;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .13s;
    }

    .btn-submit-app:hover {
        background: var(--blue-600);
    }

    .btn-submit-app svg {
        width: 14px;
        height: 14px;
        fill: #fff;
    }

    .err-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 7px;
        padding: .75rem 1rem;
        margin-bottom: 1rem;
        font-size: .82rem;
        color: #b91c1c;
    }
</style>

<a href="<?= base_url('/filieres') ?>" class="back-link">
    <svg viewBox="0 0 24 24">
        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
    </svg>
    Retour aux filières
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg viewBox="0 0 24 24">
            <path d="M22 11V3h-7v3H9V3H2v8h7V8h2v10h4v3h7v-8h-7v3h-2V8h2v3h7zM7 9H4V5h3v4zm10 6h3v4h-3v-4zm0-10h3v4h-3V5z" />
        </svg>
        <h2>Ajouter une filière</h2>
    </div>
    <div class="form-card-body">
        <?php if (session('errors')): ?>
            <div class="err-box">
                <?php foreach (session('errors') as $e): ?><div>• <?= $e ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('/filieres/store') ?>" method="POST" id="frm">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="f-label">Nom de la filière</label>
                <input type="text" name="nom" class="f-input"
                    value="<?= old('nom') ?>"
                    placeholder="Ex : Informatique et Télécommunications"
                    autofocus>
            </div>
    </div>
    <div class="form-card-foot">
        <a href="<?= base_url('/filieres') ?>" class="btn-cancel-app">Annuler</a>
        <button type="submit" form="frm" class="btn-submit-app">
            <svg viewBox="0 0 24 24">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
            </svg>
            Enregistrer
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>