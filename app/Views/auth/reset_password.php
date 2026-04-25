<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — ENSPM Gestion EDT</title>
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
        .input-wrap .btn-eye {
            background: none;
            border: none;
            border-left: 1px solid #e5e7eb;
            padding: 0 10px;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            height: 38px;
            transition: color 0.15s;
        }
        .input-wrap .btn-eye:hover { color: #374151; }

        /* Indicateur de force */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }
        .strength-bar span {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: #e5e7eb;
            transition: background 0.2s;
        }
        .strength-label {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }

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

    <h1 class="page-title">Nouveau mot de passe</h1>
    <p class="page-subtitle">Saisissez et confirmez votre nouveau mot de passe.</p>

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
    <form action="<?= base_url('/password-reset') ?>" method="POST" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="token" value="<?= esc($token) ?>">

        <!-- Nouveau mot de passe -->
        <div class="field">
            <label for="password">Nouveau mot de passe</label>
            <div class="input-wrap">
                <span class="ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                </span>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       autocomplete="new-password"
                       required>
                <button type="button" class="btn-eye" id="togglePwd1" title="Afficher / masquer">
                    <svg id="eye1" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </button>
            </div>
            <!-- Indicateur de force -->
            <div class="strength-bar">
                <span id="s1"></span><span id="s2"></span><span id="s3"></span><span id="s4"></span>
            </div>
            <div class="strength-label" id="strengthLabel"></div>
        </div>

        <!-- Confirmation -->
        <div class="field">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <div class="input-wrap">
                <span class="ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                </span>
                <input type="password"
                       id="password_confirm"
                       name="password_confirm"
                       placeholder="••••••••"
                       autocomplete="new-password"
                       required>
                <button type="button" class="btn-eye" id="togglePwd2" title="Afficher / masquer">
                    <svg id="eye2" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            Enregistrer le mot de passe
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

<script>
    const eyePath = {
        show: '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>',
        hide: '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>'
    };

    function toggleEye(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const ico   = document.getElementById(eyeId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        ico.innerHTML = show ? eyePath.hide : eyePath.show;
    }

    document.getElementById('togglePwd1').addEventListener('click', () => toggleEye('password', 'eye1'));
    document.getElementById('togglePwd2').addEventListener('click', () => toggleEye('password_confirm', 'eye2'));

    /* Indicateur de force */
    const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
    const labels = ['Très faible', 'Faible', 'Moyen', 'Fort'];

    document.getElementById('password').addEventListener('input', function () {
        const v = this.value;
        let score = 0;
        if (v.length >= 8)                  score++;
        if (/[A-Z]/.test(v))                score++;
        if (/[0-9]/.test(v))                score++;
        if (/[^A-Za-z0-9]/.test(v))         score++;

        for (let i = 1; i <= 4; i++) {
            document.getElementById('s' + i).style.background = i <= score ? colors[score - 1] : '#e5e7eb';
        }
        document.getElementById('strengthLabel').textContent = v.length ? labels[score - 1] || '' : '';
        document.getElementById('strengthLabel').style.color  = v.length ? colors[score - 1] : '#9ca3af';
    });
</script>

</body>
</html>