<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ENSPM — Gestion EDT') ?></title>
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
            --gray-800: #1e293b;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-400: #9ca3af;
            --gray-300: #d1d5db;
            --gray-200: #e5e7eb;
            --gray-100: #f3f4f6;
            --gray-50:  #f8fafc;
            --sidebar-w: 252px;
            --navbar-h:  58px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--gray-100);
            color: var(--gray-900);
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--blue-900);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform 0.28s ease;
        }

        /* Brand */
        .sidebar-brand {
            height: var(--navbar-h);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .brand-name   { font-size: 0.9rem; font-weight: 700; color: #fff; line-height: 1.1; }
        .brand-sub    { font-size: 0.65rem; color: rgba(255,255,255,0.4); letter-spacing: 0.5px; margin-top: 1px; }

        /* Navigation */
        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.75rem 0;
        }

        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        .nav-section {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.28);
            padding: 1rem 1.25rem 0.35rem;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.58rem 1.25rem;
            font-size: 0.845rem;
            font-weight: 500;
            color: rgba(255,255,255,0.62);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.15s;
            position: relative;
        }

        .nav-link-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }

        .nav-link-item.active {
            background: rgba(59,130,246,0.15);
            color: #fff;
            border-left-color: var(--blue-400);
        }

        .nav-link-item i { font-size: 1rem; width: 18px; text-align: center; flex-shrink: 0; }

        /* Pied sidebar */
        .sidebar-foot {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sidebar-year {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.28);
            text-align: center;
        }

        /* ─── NAVBAR ─── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--navbar-h);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 100;
            transition: left 0.28s ease;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .btn-toggle {
            display: none;
            width: 34px; height: 34px;
            background: none;
            border: 1px solid var(--gray-200);
            border-radius: 7px;
            align-items: center; justify-content: center;
            color: var(--gray-700);
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-toggle:hover { background: var(--gray-100); }

        @media (max-width: 1023px) { .btn-toggle { display: flex; } }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .page-breadcrumb .current {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.3rem 0.75rem 0.3rem 0.35rem;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 999px;
            cursor: default;
        }

        .user-avatar {
            width: 30px; height: 30px;
            background: var(--blue-600);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            letter-spacing: 0.5px;
        }

        .user-name { font-size: 0.82rem; font-weight: 600; color: var(--gray-900); }
        .user-role { font-size: 0.68rem; color: var(--gray-500); line-height: 1; margin-top: 1px; }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.875rem;
            background: none;
            border: 1px solid var(--gray-200);
            border-radius: 7px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-logout:hover {
            background: #fff1f2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* ─── CONTENU ─── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            margin-top: var(--navbar-h);
            padding: 1.5rem;
            min-height: calc(100vh - var(--navbar-h));
            transition: margin-left 0.28s ease;
        }

        /* ─── TOAST FLASH ─── */
        .toast-stack {
            position: fixed;
            top: calc(var(--navbar-h) + 1rem);
            right: 1.25rem;
            z-index: 500;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        }

        .toast-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1.1rem;
            background: #fff;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            border-left: 3px solid;
            font-size: 0.855rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            min-width: 280px;
            max-width: 360px;
            pointer-events: all;
            animation: toastIn 0.25s ease-out;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .toast-success { border-left-color: #16a34a; color: #15803d; }
        .toast-error   { border-left-color: #dc2626; color: #b91c1c; }

        /* ─── Responsive ─── */
        @media (max-width: 1023px) {
            .sidebar    { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar     { left: 0; }
            .main-wrap  { margin-left: 0; }
            .user-name, .user-role { display: none; }
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 150;
        }

        .sidebar-overlay.show { display: block; }
    </style>
</head>
<body>

    <!-- ─── SIDEBAR ─── -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="brand-name">ENSPM</div>
                <div class="brand-sub">Gestion EDT · INFOTEL</div>
            </div>
        </div>

        <nav class="sidebar-scroll">

            <span class="nav-section">Principal</span>
            <a href="<?= base_url('/dashboard') ?>"
               class="nav-link-item <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2"></i> Tableau de bord
            </a>

            <?php if (in_array(session()->get('user_role'), ['admin', 'cd'])): ?>

            <span class="nav-section">Ressources</span>
            <a href="<?= base_url('/enseignants') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'enseignants') ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i> Enseignants
            </a>
            <a href="<?= base_url('/cours') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'cours') ? 'active' : '' ?>">
                <i class="bi bi-book"></i> Cours
            </a>
            <a href="<?= base_url('/salles') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'salles') ? 'active' : '' ?>">
                <i class="bi bi-building"></i> Salles
            </a>
            <a href="<?= base_url('/filieres') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'filieres') ? 'active' : '' ?>">
                <i class="bi bi-diagram-3"></i> Filières
            </a>

            <span class="nav-section">Emploi du Temps</span>
            <a href="<?= base_url('/edt/construire') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'edt/construire') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-plus"></i> Construire un EDT
            </a>
            <a href="<?= base_url('/edt/consulter') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'edt/consulter') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-week"></i> Consulter / Filtrer
            </a>
            <a href="<?= base_url('/edt/export') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'edt/export') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
            </a>

            <span class="nav-section">Administration</span>
            <a href="<?= base_url('/utilisateurs') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'utilisateurs') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Utilisateurs
            </a>
            <a href="<?= base_url('/historique') ?>"
               class="nav-link-item <?= str_starts_with(uri_string(), 'historique') ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i> Historique
            </a>

            <?php endif; ?>

            <?php if (session()->get('user_role') === 'enseignant'): ?>

            <span class="nav-section">Mon Espace</span>
            <a href="<?= base_url('/mon-planning') ?>"
               class="nav-link-item <?= uri_string() === 'mon-planning' ? 'active' : '' ?>">
                <i class="bi bi-calendar-week"></i> Mon planning
            </a>
            <a href="<?= base_url('/mes-disponibilites') ?>"
               class="nav-link-item <?= uri_string() === 'mes-disponibilites' ? 'active' : '' ?>">
                <i class="bi bi-check2-square"></i> Mes disponibilités
            </a>

            <?php endif; ?>

        </nav>

        <div class="sidebar-foot">
            <div class="sidebar-year">Année académique 2025 – 2026</div>
        </div>
    </aside>

    <!-- Overlay mobile -->
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- ─── TOPBAR ─── -->
    <header class="topbar" id="topbar">
        <div class="topbar-left">
            <button class="btn-toggle" id="btnToggle" title="Menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="page-breadcrumb">
                <span>INFOTEL</span>
                <i class="bi bi-chevron-right" style="font-size:0.65rem;"></i>
                <span class="current"><?= esc($title ?? 'Tableau de bord') ?></span>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-pill">
                <div class="user-avatar">
                    <?= strtoupper(
                        substr(session()->get('user_prenom') ?? 'U', 0, 1) .
                        substr(session()->get('user_nom')    ?? '',  0, 1)
                    ) ?>
                </div>
                <div>
                    <div class="user-name"><?= esc(session()->get('user_name')) ?></div>
                    <div class="user-role"><?= esc(\App\Models\UserModel::libelleRole(session()->get('user_role') ?? '')) ?></div>
                </div>
            </div>

            <a href="<?= base_url('/logout') ?>" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                Déconnexion
            </a>
        </div>
    </header>

    <!-- ─── TOASTS FLASH ─── -->
    <div class="toast-stack" id="toastStack">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="toast-item toast-success" data-auto-close>
                <i class="bi bi-check-circle-fill" style="font-size:1rem;flex-shrink:0;"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="toast-item toast-error" data-auto-close>
                <i class="bi bi-exclamation-circle-fill" style="font-size:1rem;flex-shrink:0;"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ─── CONTENU ─── -->
    <main class="main-wrap">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const btnToggle = document.getElementById('btnToggle');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

        // Ferme les toasts après 4s
        document.querySelectorAll('[data-auto-close]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });
    </script>
</body>
</html>
