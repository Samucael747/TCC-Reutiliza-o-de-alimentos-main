<?php
$paginaAtiva = $paginaAtiva ?? '';
$base = (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false) ? '../' : './';
?>
<nav class="navbar">
    <div class="navbar-content">
        <a href="home.php" class="navbar-brand">
            <img src="<?php echo $base; ?>Imagens/Logo.png" alt="Logo FomeOff" class="site-logo" />
            <span class="navbar-brand-name">FomeOff</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="home.php"<?php if ($paginaAtiva === 'home') echo ' class="active"'; ?>><i class="bi bi-house-door"></i> Home</a></li>
            <li><a href="doacoes.php"<?php if ($paginaAtiva === 'doacoes') echo ' class="active"'; ?>><i class="bi bi-box-seam"></i> Doa&ccedil;&otilde;es</a></li>
            <li><a href="leis_doacoes.php"<?php if ($paginaAtiva === 'leis') echo ' class="active"'; ?>><i class="bi bi-book"></i> Leis</a></li>
            <li><a href="configuracoes.php"<?php if ($paginaAtiva === 'configuracoes') echo ' class="active"'; ?>><i class="bi bi-gear"></i> Configura&ccedil;&otilde;es</a></li>
        </ul>
        <?php if ($paginaAtiva === 'home'): ?>
        <div class="navbar-location" id="locationBadge">
            <i class="bi bi-geo-alt-fill"></i>
            <span class="location-text">Localizando...</span>
        </div>
        <?php endif; ?>
        <a href="logout.php" class="navbar-sair"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>
</nav>
