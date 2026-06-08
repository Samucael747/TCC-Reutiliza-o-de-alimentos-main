<?php
$paginaAtiva = $paginaAtiva ?? '';
$inPhp  = strpos($_SERVER['SCRIPT_NAME'], '/php/')  !== false;
$inHtml = strpos($_SERVER['SCRIPT_NAME'], '/auth/') !== false;
$base   = ($inPhp || $inHtml) ? '../' : './';
$p      = $inHtml ? '../php/' : '';   // prefixo para links de páginas PHP
?>
<nav class="navbar">
    <div class="navbar-content">
        <a href="<?php echo $p; ?>dashboard.php" class="navbar-brand">
            <img src="<?php echo $base; ?>Imagens/Logo.png" alt="Logo FomeOff" class="site-logo" />
            <span class="navbar-brand-name">FomeOff</span>
        </a>
        <ul class="navbar-menu">
            <li class="menu-item">
                <a href="#">Sobre Empresas</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo $p; ?>doacoes.php"<?php if ($paginaAtiva === 'doacoes') echo ' class="active"'; ?>>Doa&ccedil;&otilde;es</a></li>
                    <li><a href="<?php echo $p; ?>conquistas.php"<?php if ($paginaAtiva === 'conquistas') echo ' class="active"'; ?>>Conquistas</a></li>
                    <li><a href="<?php echo $p; ?>leis_doacoes.php"<?php if ($paginaAtiva === 'leis') echo ' class="active"'; ?>>Leis</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $p; ?>chat.php"<?php if ($paginaAtiva === 'chat') echo ' class="active"'; ?>><i class="bi bi-chat-dots"></i> Chat</a></li>
        
            <li><a href="<?php echo $p; ?>configuracoes.php"<?php if ($paginaAtiva === 'configuracoes') echo ' class="active"'; ?>><i class="bi bi-gear"></i> Configura&ccedil;&otilde;es</a></li>
        </ul>
        <form class="navbar-search" onsubmit="return handleNavbarSearch(event)">
            <input type="search" name="q" placeholder="Buscar páginas..." aria-label="Buscar páginas" />
            <button type="submit" title="Pesquisar"><i class="bi bi-search"></i></button>
        </form>
        <?php if ($paginaAtiva === 'dashboard'): ?>
        <div class="navbar-location" id="locationBadge">
            <i class="bi bi-geo-alt-fill"></i>
            <span class="location-text">Localizando...</span>
            <span class="navbar-clock" id="navbarClock">--/--/---- --:--</span>
        </div>
        <?php endif; ?>
        <a href="<?php echo $p; ?>actions/logout.php" class="navbar-sair"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>
</nav>
<script>
    function handleNavbarSearch(event) {
        event.preventDefault();
        const query = (event.target.q.value || '').trim().toLowerCase();
        const pages = {
            'doações': '<?php echo $p; ?>doacoes.php',
            'doacoes': '<?php echo $p; ?>doacoes.php',
            'conquistas': '<?php echo $p; ?>conquistas.php',
            'leis': '<?php echo $p; ?>leis_doacoes.php',
            'chat': '<?php echo $p; ?>chat.php',
            'voluntários': '<?php echo $p; ?>chat.php',
            'voluntarios': '<?php echo $p; ?>chat.php',
            'voluntario': '<?php echo $p; ?>chat.php',
            'configurações': '<?php echo $p; ?>configuracoes.php',
            'configuracoes': '<?php echo $p; ?>configuracoes.php',
            'dashboard': '<?php echo $p; ?>dashboard.php'
        };
        if (!query) {
            window.location.href = '<?php echo $p; ?>dashboard.php';
            return false;
        }
        if (pages[query]) {
            window.location.href = pages[query];
            return false;
        }
        if (query.includes('lei')) {
            window.location.href = '<?php echo $p; ?>leis_doacoes.php';
            return false;
        }
        if (query.includes('conquist')) {
            window.location.href = '<?php echo $p; ?>conquistas.php';
            return false;
        }
        if (query.includes('doa')) {
            window.location.href = '<?php echo $p; ?>doacoes.php';
            return false;
        }
        if (query.includes('config')) {
            window.location.href = '<?php echo $p; ?>configuracoes.php';
            return false;
        }
        window.location.href = '<?php echo $p; ?>dashboard.php';
        return false;
    }
</script>


