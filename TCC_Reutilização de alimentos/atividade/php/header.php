<?php
// Header reutilizável. Calcula caminho base para imagens/link relativo ao diretório atual.
$base = (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false) ? '../' : './';
?>
<header class="site-header" role="banner">
    <div class="site-header-inner">
        <img src="<?php echo $base; ?>Imagens/Logo.jpg" alt="Logo FomeOff" class="site-header-logo" />
        <div class="site-header-title">FomeOff</div>
    </div>
</header>
