<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — ENSPM Gestion EDT</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --blue-900: #0a1628;
            --blue-800: #0f2444;
            --blue-700: #1a3a6b;
            --blue-600: #1e4d9b;
            --blue-500: #2563eb;
            --blue-400: #3b82f6;
            --blue-100: #dbeafe;
            --blue-50:  #eff6ff;
            --gray-900: #0f172a;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-300: #d1d5db;
            --gray-200: #e5e7eb;
            --gray-50:  #f9fafb;
            --red-600:  #dc2626;
            --red-50:   #fef2f2;
            --green-600:#16a34a;
            --green-50: #f0fdf4;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--gray-50);
        }

        /* ─── Panneau gauche ─── */
        .left-panel {
            display: none;
            width: 45%;
            background: var(--blue-800);
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 1024px) { .left-panel { display: flex; } }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -140px; right: -140px;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 90px solid rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 70px solid rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .left-top    { position: relative; z-index: 1; }
        .left-bottom { position: relative; z-index: 1; }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 3rem;
        }

        .left-logo-icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.3rem;
        }

        .logo-school { font-size: 0.68rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.45); }
        .logo-dept   { font-size: 0.92rem; font-weight: 600; color: #fff; margin-top: 2px; }

        .left-headline { font-size: 1.8rem; font-weight: 700; color: #fff; line-height: 1.3; margin-bottom: 0.875rem; }
        .left-desc     { font-size: 0.875rem; color: rgba(255,255,255,0.5); line-height: 1.65; }

        .features { margin-top: 0; }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 0;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .feature:last-child { border-bottom: 1px solid rgba(255,255,255,0.07); }

        .feature-ico {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.07);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--blue-400);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .feature span { font-size: 0.83rem; color: rgba(255,255,255,0.6); }

        /* ─── Panneau droit ─── */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
        }

        .login-box { width: 100%; max-width: 400px; }

        /* En-tête mobile */
        .mobile-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.25rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        @media (min-width: 1024px) { .mobile-header { display: none; } }

        .mob-icon {
            width: 40px; height: 40px;
            background: var(--blue-600);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.15rem;
        }

        .mob-school { font-size: 0.67rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--gray-500); }
        .mob-dept   { font-size: 0.88rem; font-weight: 600; color: var(--gray-900); }

        /* Titre */
        .form-heading    { font-size: 1.45rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.35rem; }
        .form-subheading { font-size: 0.875rem; color: var(--gray-500); margin-bottom: 2rem; }

        /* Alertes */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.855rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid;
            line-height: 1.5;
        }

        .alert-error   { background: var(--red-50);   color: var(--red-600);   border-color: var(--red-600); }
        .alert-success { background: var(--green-50); color: var(--green-600); border-color: var(--green-600); }
        .alert-ico     { font-size: 0.95rem; flex-shrink: 0; margin-top: 2px; }

        /* Champs */
        .field-group  { margin-bottom: 1.2rem; }
        .field-label  { display: block; font-size: 0.8rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.45rem; letter-spacing: 0.2px; }
        .field-wrap   { position: relative; }

        .field-icon {
            position: absolute;
            left: 0.85rem; top: 50%; transform: translateY(-50%);
            color: var(--gray-500); font-size: 0.95rem;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            height: 42px;
            padding: 0 2.75rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 7px;
            font-size: 0.88rem;
            color: var(--gray-900);
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field-input:hover  { border-color: var(--gray-300); }
        .field-input:focus  { border-color: var(--blue-500); box-shadow: 0 0 0 3px rgba(37,99,235,0.09); }
        .field-input.err    { border-color: var(--red-600); }

        .field-action {
            position: absolute;
            right: 0.85rem; top: 50%; transform: translateY(-50%);
            background: none; border: none;
            color: var(--gray-500); cursor: pointer;
            font-size: 0.95rem; padding: 0; line-height: 1;
            transition: color 0.15s;
        }

        .field-action:hover { color: var(--blue-500); }

        /* Bouton */
        .btn-submit {
            width: 100%;
            height: 42px;
            background: var(--blue-600);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.15s, transform 0.1s;
            margin-top: 0.25rem;
        }

        .btn-submit:hover  { background: var(--blue-700); }
        .btn-submit:active { transform: scale(0.99); }

        /* Séparateur + badges */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.75rem 0 1.25rem;
        }

        .divider-line { flex: 1; height: 1px; background: var(--gray-200); }
        .divider-text { font-size: 0.75rem; color: var(--gray-500); white-space: nowrap; }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }

        .role-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            padding: 0.6rem 0.4rem;
            border-radius: 7px;
            border: 1px solid var(--gray-200);
            background: #fff;
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--gray-700);
            text-align: center;
        }

        .role-card i { font-size: 1.1rem; }
        .rc-admin     i { color: #b45309; }
        .rc-cd        i { color: #4338ca; }
        .rc-enseignant i { color: var(--blue-600); }

        .login-footer {
            margin-top: 1.75rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray-500);
        }
    </style>
</head>
<body>

    <!-- ─── Panneau gauche ─── -->
    <div class="left-panel">
        <div class="left-top">
            <div class="left-logo">
                <div class="left-logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <div class="logo-school">Université de Maroua</div>
                    <div class="logo-dept">ENSPM — Département INFOTEL</div>
                </div>
            </div>
            <h1 class="left-headline">Gestion des<br>Emplois du Temps</h1>
            <p class="left-desc">Plateforme centralisée de planification et de diffusion des emplois du temps du département INFOTEL — Année 2025–2026.</p>
        </div>

        <div class="left-bottom">
            <div class="features">
                <div class="feature">
                    <div class="feature-ico"><i class="bi bi-calendar2-check"></i></div>
                    <span>Construction interactive des emplois du temps</span>
                </div>
                <div class="feature">
                    <div class="feature-ico"><i class="bi bi-shield-check"></i></div>
                    <span>Détection automatique des conflits de planning</span>
                </div>
                <div class="feature">
                    <div class="feature-ico"><i class="bi bi-file-earmark-pdf"></i></div>
                    <span>Export PDF au format officiel ENSPM</span>
                </div>
                <div class="feature">
                    <div class="feature-ico"><i class="bi bi-bar-chart-line"></i></div>
                    <span>Tableau de bord et statistiques de charge horaire</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Panneau droit ─── -->
    <div class="right-panel">
        <div class="login-box">

            <!-- En-tête mobile -->
            <div class="mobile-header">
                <div class="mob-icon"><i class="bi bi-mortarboard-fill"></i></div>
                <div>
                    <div class="mob-school">ENSPM — Université de Maroua</div>
                    <div class="mob-dept">Département INFOTEL</div>
                </div>
            </div>

            <h2 class="form-heading">Connexion</h2>
            <p class="form-subheading">Accédez à votre espace de gestion</p>

            <!-- Alertes -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-box alert-error">
                    <i class="bi bi-exclamation-circle-fill alert-ico"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert-box alert-success">
                    <i class="bi bi-check-circle-fill alert-ico"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert-box alert-error">
                    <i class="bi bi-exclamation-circle-fill alert-ico"></i>
                    <div><?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form action="<?= base_url('/login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="field-group">
                    <label class="field-label" for="email">Adresse email</label>
                    <div class="field-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" id="email" name="email"
                               class="field-input <?= session()->getFlashdata('errors') ? 'err' : '' ?>"
                               value="<?= esc(old('email')) ?>"
                               placeholder="votre.email@enspm.cm"
                               autocomplete="email" required>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Mot de passe</label>
                    <div class="field-wrap">
                        <i class="bi bi-lock field-icon"></i>
                        <input type="password" id="password" name="password"
                               class="field-input"
                               placeholder="••••••••"
                               autocomplete="current-password" required>
                        <button type="button" class="field-action" id="togglePwd">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Se connecter
                </button>
            </form>

            <div class="login-footer">
                Année académique 2025 – 2026 &nbsp;&middot;&nbsp; ENSPM Maroua
            </div>

        </div>
    </div>

    <script>
        const pwd = document.getElementById('password');
        const ico = document.getElementById('eyeIcon');
        document.getElementById('togglePwd').addEventListener('click', () => {
            const show = pwd.type === 'password';
            pwd.type   = show ? 'text' : 'password';
            ico.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
</body>
</html>
