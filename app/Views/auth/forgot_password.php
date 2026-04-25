<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — ENSPM Gestion EDT</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f5f7;
            padding: 1.5rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 390px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            background: #0f2444;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .logo-icon svg { width: 18px; height: 18px; fill: #ffffff; }
        .logo-school { font-size: 11px; color: #6b7280; letter-spacing: 0.3px; }
        .logo-dept   { font-size: 13px; font-weight: 600; color: #111827; margin-top: 1px; }

        .page-title    { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 4px; }
        .page-subtitle { font-size: 13px; color: #6b7280; margin: 0 0 1.5rem; line-height: 1.5; }

        .alert {
            font-size: 13px;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            gap: 8px;
            align-items: flex-start;
            border: 1px solid transparent;
        }
        .alert-danger  { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .alert svg { flex-shrink: 0; margin-top: 1px; }

        .field { margin-bottom: 1rem; }
        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }
        .input-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .input-wrap:focus-within {
            border-color: #0f2444;
            box-shadow: 0 0 0 3px rgba(15,36,68,0.1);
        }
        .input-wrap .ico {
            padding: 0 10px;
            color: #9ca3af;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        .input-wrap input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 9px 0;
            font-size: 14px;
            color: #111827;
            min-width: 0;
        }
        .input-wrap input::placeholder { color: #9ca3af; }

        .btn-submit {
            width: 100%;
            background: #0f2444;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit:hover  { background: #0a1a33; }
        .btn-submit:active { background: #071020; }

        .back-link {
            text-align: center;
            margin-top: 1.25rem;
        }
        .back-link a {
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .back-link a:hover { color: #0f2444; }

        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>

<div class="card">

    <!-- Logo -->
    <div class="logo-row">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
            </svg>
        </div>
        <div>
            <div class="logo-school">ENSPM — Université de Maroua</div>
            <div class="logo-dept">Département INFOTEL</div>
        </div>
    </div>

    <h1 class="page-title">Mot de passe oublié</h1>
    <p class="page-subtitle">Renseignez votre adresse email pour recevoir le lien de réinitialisation.</p>

    <!-- Alertes -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;margin-top:1px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <div>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Formulaire -->
    <form action="<?= base_url('/forgot-password') ?>" method="POST" novalidate>
        <?= csrf_field() ?>

        <div class="field">
            <label for="email">Adresse email</label>
            <div class="input-wrap">
                <span class="ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </span>
                <input type="email"
                       id="email"
                       name="email"
                       value="<?= esc(old('email')) ?>"
                       placeholder="votre.email@enspm.cm"
                       autocomplete="email"
                       required>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            Envoyer le lien
        </button>
    </form>

    <div class="back-link">
        <a href="<?= base_url('/login') ?>">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            Retour à la connexion
        </a>
    </div>

    <div class="footer-note">Année académique 2025 – 2026 &middot; ENSPM Maroua</div>

</div>

</body>
</html>