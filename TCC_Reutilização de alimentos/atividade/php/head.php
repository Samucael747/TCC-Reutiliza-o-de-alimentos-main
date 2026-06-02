<?php
$base = (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false) ? '../' : './';
$pageTitle = $pageTitle ?? 'FomeOff';
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>css/index.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>css/acessibilidade.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>css/accessibility-panel.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <style>
        /* ── Navbar global ── */
        .navbar {
            background: white;
            padding: 18px 24px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999999;
        }
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #E8411C;
            font-weight: 700;
            font-size: 1.3rem;
        }
        .site-logo { height: 38px; width: auto; border-radius: 8px; }
        .navbar-brand-name {
            font-size: 1.2rem;
            font-weight: 800;
            color: #E8411C;
            letter-spacing: -0.02em;
        }
        .navbar-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 18px;
            align-items: center;
        }
        .navbar-menu a {
            text-decoration: none;
            color: #444;
            font-weight: 500;
            transition: color 0.2s;
        }
        .navbar-menu a:hover { color: #FF8C00; }
        .navbar-menu a.active { color: #FF8C00; font-weight: 600; }
        .navbar-sair {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }
        .navbar-sair:hover { color: #FF8C00; }
        .navbar-location {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8f8ee;
            color: #1f6f3f;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid #c9f0d6;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
        }
        @media (max-width: 768px) {
            .navbar-content { flex-wrap: wrap; gap: 10px; }
            .navbar-menu { gap: 12px; flex-wrap: wrap; }
        }

        /* ── Ícones Bootstrap Icons — espaçamento global ── */
        a, button { gap: 6px; }
        .navbar-menu a { display: inline-flex; align-items: center; gap: 6px; }
        .navbar-sair  { display: inline-flex; align-items: center; gap: 6px; }

        /* ── Footer global ── */
        .footer {
            background: linear-gradient(135deg, #E8411C, #FF8C00);
            color: white;
            text-align: center;
            padding: 24px 20px;
            margin-top: 40px;
        }
        .footer p { margin: 0; font-size: 0.9rem; opacity: 0.95; }
    </style>
    <?php if (!empty($extra_head)) echo $extra_head; ?>
</head>
