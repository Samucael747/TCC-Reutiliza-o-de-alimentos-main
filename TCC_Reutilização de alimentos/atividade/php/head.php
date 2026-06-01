<?php
// Central head include. Usage:
// $pageTitle = 'Página | Título';
// $extra_head = <<<'HTML'
//   ... additional <link> or <style> ...
// HTML;

$base = (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false) ? '../' : './';
$pageTitle = $pageTitle ?? 'FomeOff';
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>css/index.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>css/acessibilidade.css" />
    <?php if (!empty($extra_head)) echo $extra_head; ?>
</head>
<?php
// head.php - Cabeçalho HTML centralizado usado por todas as páginas.
// Use as variáveis antes de incluir este arquivo:
//   $pageTitle (string) - título da página
//   $extra_head (string) - conteúdo HTML a ser inserido dentro de <head> (opcional)

$pageTitle = $pageTitle ?? 'FomeOff';
$extra_head = $extra_head ?? '';

$base = (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false) ? '../' : './';
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>css/index.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>css/acessibilidade.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>css/accessibility-panel.css" />
    <?php echo $extra_head; ?>
</head>
