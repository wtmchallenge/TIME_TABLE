<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ENSPM — Gestion EDT') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
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
            --sidebar-w: 248px;
            --navbar-h:  56px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--gray-100);
            color: var(--gray-900);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--blue-900);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform 0.26s ease;
        }

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
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-icon svg { width: 16px; height: 16px; fill: #fff; }

        .brand-name { font-size: 0.88rem; font-weight: 700; color: #fff; line-height: 1.1; }
        .brand-sub  { font-size: 0.63rem; color: rgba(255,255,255,0.35); letter-spacing: 0.4px; margin-top: 2px; }

        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.5rem 0;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 2px; }

        .nav-section {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 1rem 1.25rem 0.3rem;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.835rem;
            font-weight: 500;
            color: rgba(255,255,255,0.58);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.14s;
        }
        .nav-link-item svg { width: 15px; height: 15px; flex-shrink: 0; fill: currentColor; }
        .nav-link-item:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.88);
        }
        .nav-link-item.active {
            background: rgba(59,130,246,0.13);
            color: #fff;
            border-left-color: var(--blue-400);
        }

        .sidebar-foot {
            padding: 0.875rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .sidebar-year {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.25);
            text-align: center;
        }

        /* ── TOPBAR ── */
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
            transition: left 0.26s ease;
        }

        .topbar-left { display: flex; align-items: center; gap: 0.875rem; }

        .btn-toggle {
            display: none;
            width: 32px; height: 32px;
            background: none;
            border: 1px solid var(--gray-200);
            border-radius: 7px;
            align-items: center; justify-content: center;
            color: var(--gray-700);
            cursor: pointer;
            transition: background 0.14s;
        }
        .btn-toggle svg { width: 16px; height: 16px; fill: currentColor; }
        .btn-toggle:hover { background: var(--gray-100); }
        @media (max-width: 1023px) { .btn-toggle { display: flex; } }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.78rem;
            color: var(--gray-500);
        }
        .page-breadcrumb svg { width: 10px; height: 10px; fill: var(--gray-400); }
        .page-breadcrumb .current {
            font-size: 0.855rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.28rem 0.75rem 0.28rem 0.3rem;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 999px;
            cursor: default;
        }
        .user-avatar {
            width: 28px; height: 28px;
            background: var(--blue-600);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            letter-spacing: 0.5px;
        }
        .user-name { font-size: 0.8rem; font-weight: 600; color: var(--gray-900); }
        .user-role { font-size: 0.67rem; color: var(--gray-500); line-height: 1; margin-top: 1px; }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.38rem 0.85rem;
            background: none;
            border: 1px solid var(--gray-200);
            border-radius: 7px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.14s;
            white-space: nowrap;
        }
        .btn-logout svg { width: 13px; height: 13px; fill: currentColor; }
        .btn-logout:hover {
            background: #fff1f2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* ── CONTENU ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            margin-top: var(--navbar-h);
            padding: 1.5rem;
            min-height: calc(100vh - var(--navbar-h));
            transition: margin-left 0.26s ease;
        }

        /* ── TOASTS ── */
        .toast-stack {
            position: fixed;
            top: calc(var(--navbar-h) + 0.875rem);
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
            padding: 0.7rem 1rem;
            background: #fff;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            border-left: 3px solid;
            font-size: 0.84rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            min-width: 260px;
            max-width: 340px;
            pointer-events: all;
            animation: toastIn 0.22s ease-out;
        }
        .toast-item svg { width: 15px; height: 15px; flex-shrink: 0; fill: currentColor; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .toast-success { border-left-color: #16a34a; color: #15803d; }
        .toast-error   { border-left-color: #dc2626; color: #b91c1c; }

        /* ── Responsive ── */
        @media (max-width: 1023px) {
            .sidebar   { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar    { left: 0; }
            .main-wrap { margin-left: 0; }
            .user-name, .user-role { display: none; }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.38);
            z-index: 150;
        }
        .sidebar-overlay.show { display: block; }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
        </div>
        <div>
            <div class="brand-name">ENSPM</div>
            <div class="brand-sub">Gestion EDT · INFOTEL</div>
        </div>
    </div>

    <nav class="sidebar-scroll">

        <span class="nav-section">Principal</span>
        <a href="<?= base_url('/dashboard') ?>"
           class="nav-link-item <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm0 10h8v8H3v-8zm10-10h8v8h-8V3zm0 10h8v8h-8v-8z"/></svg>
            Tableau de bord
        </a>

        <?php if (in_array(session()->get('user_role'), ['admin', 'cd'])): ?>

        <span class="nav-section">Ressources</span>
        <a href="<?= base_url('/enseignants') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'enseignants') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Enseignants
        </a>
        <a href="<?= base_url('/cours') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'cours') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
            Cours
        </a>
        <a href="<?= base_url('/salles') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'salles') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
            Salles
        </a>
        <a href="<?= base_url('/filieres') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'filieres') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M22 11V3h-7v3H9V3H2v8h7V8h2v10h4v3h7v-8h-7v3h-2V8h2v3h7zM7 9H4V5h3v4zm10 6h3v4h-3v-4zm0-10h3v4h-3V5z"/></svg>
            Filières
        </a>

        <span class="nav-section">Emploi du Temps</span>
        <a href="<?= base_url('/edt/construire') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'edt/construire') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-4-4 1.41-1.41L12 14.17l6.59-6.59L20 9l-8 8z"/></svg>
            Construire un EDT
        </a>
        <a href="<?= base_url('/edt/consulter') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'edt/consulter') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>
            Consulter / Filtrer
        </a>
        <a href="<?= base_url('/edt/export') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'edt/export') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg>
            Exporter PDF
        </a>

        <span class="nav-section">Administration</span>
        <a href="<?= base_url('/utilisateurs') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'utilisateurs') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Utilisateurs
        </a>
        <a href="<?= base_url('/historique') ?>"
           class="nav-link-item <?= str_starts_with(uri_string(), 'historique') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
            Historique
        </a>

        <?php endif; ?>

        <?php if (session()->get('user_role') === 'enseignant'): ?>

        <span class="nav-section">Mon Espace</span>
        <a href="<?= base_url('/mon-planning') ?>"
           class="nav-link-item <?= uri_string() === 'mon-planning' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>
            Mon planning
        </a>
        <a href="<?= base_url('/mes-disponibilites') ?>"
           class="nav-link-item <?= uri_string() === 'mes-disponibilites' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-8 9z"/></svg>
            Mes disponibilités
        </a>

        <?php endif; ?>

    </nav>

    <div class="sidebar-foot">
        <div class="sidebar-year">Année académique 2025 – 2026</div>
    </div>
</aside>

<!-- Overlay mobile -->
<div class="sidebar-overlay" id="overlay"></div>

<!-- ── TOPBAR ── -->
<header class="topbar" id="topbar">
    <div class="topbar-left">
        <button class="btn-toggle" id="btnToggle" title="Menu">
            <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
        <div class="page-breadcrumb">
            <span>INFOTEL</span>
            <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg>
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
            <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            Déconnexion
        </a>
    </div>
</header>

<!-- ── TOASTS ── -->
<div class="toast-stack" id="toastStack">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="toast-item toast-success" data-auto-close>
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="toast-item toast-error" data-auto-close>
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>
</div>

<!-- ── CONTENU ── -->
<main class="main-wrap">
    <?= $this->renderSection('content') ?>
</main>

<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script>
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('overlay');
    const btnToggle = document.getElementById('btnToggle');

    btnToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    document.querySelectorAll('[data-auto-close]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.35s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 350);
        }, 4000);
    });
</script>
</body>
</html>
