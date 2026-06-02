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
            <li><a href="<?php echo $p; ?>dashboard.php"<?php if ($paginaAtiva === 'dashboard') echo ' class="active"'; ?>><i class="bi bi-house-door"></i> Painel</a></li>
            <li><a href="<?php echo $p; ?>doacoes.php"<?php if ($paginaAtiva === 'doacoes') echo ' class="active"'; ?>><i class="bi bi-box-seam"></i> Doa&ccedil;&otilde;es</a></li>
            <li><a href="<?php echo $p; ?>leis_doacoes.php"<?php if ($paginaAtiva === 'leis') echo ' class="active"'; ?>><i class="bi bi-book"></i> Leis</a></li>
            <li><a href="<?php echo $p; ?>configuracoes.php"<?php if ($paginaAtiva === 'configuracoes') echo ' class="active"'; ?>><i class="bi bi-gear"></i> Configura&ccedil;&otilde;es</a></li>
        </ul>
        <?php if ($paginaAtiva === 'dashboard'): ?>
        <div class="navbar-location" id="locationBadge">
            <i class="bi bi-geo-alt-fill"></i>
            <span class="location-text">Localizando...</span>
        </div>
        <?php endif; ?>
        <a href="<?php echo $p; ?>actions/logout.php" class="navbar-sair"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>
</nav>


