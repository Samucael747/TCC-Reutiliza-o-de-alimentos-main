<?php
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Produtos | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
    <style>
        body { background: linear-gradient(180deg, #FFE4B5 0%, #FFF3E0 100%); }
        .content-wrapper { max-width: 760px; margin: 32px auto; padding: 20px; }
        .card { background: #fff; border-radius: 24px; box-shadow: 0 24px 60px rgba(232, 65, 28, 0.08); padding: 30px; border-top: 4px solid #FF8C00; }
        .card h2 { margin-top: 0; color: #E8411C; }
        .form-grid { display: grid; gap: 18px; }
        .form-grid label { display: grid; gap: 8px; color: #D84315; }
        .small-note { font-size: 0.95rem; color: #8B6F47; }
        .button-row { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 14px; }
        #locationStatus { font-size: 0.95rem; color: #D84315; }
    </style>
</head>
<body>
    <?php include '../php/header.php'; ?>
    <div class="content-wrapper">
        <div class="card">
            <h2>Cadastro de produtos disponíveis</h2>
            <p>Empresas podem informar itens prontos para doação e compartilhar a localização em tempo real.</p>

            <?php if ($success): ?>
                <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form action="../php/salvarProduto.php" method="post" enctype="multipart/form-data" class="form-grid">
                <label>
                    Nome da empresa
                    <input type="text" name="empresa" placeholder="Nome da empresa" required maxlength="100" />
                </label>

                <label>
                    CNPJ
                    <input type="text" name="cnpj" placeholder="00.000.000/0000-00" maxlength="20" />
                </label>

                <label>
                    CEP
                    <input type="text" name="cep" placeholder="12345-678" required maxlength="10" />
                </label>

                <label>
                    Produto disponível
                    <input type="text" name="nome_produto" placeholder="Ex: Pães, frutas, marmitas" required maxlength="100" />
                </label>

                <label>
                    Validade do produto
                    <input type="date" name="validade" required />
                </label>

                <label>
                    Foto da caixa / embalagem
                    <input type="file" name="imagem" accept="image/png,image/jpeg,image/webp" required />
                </label>

                <label>
                    Descrição
                    <textarea name="descricao" placeholder="Descreva o alimento e a quantidade" required rows="4" maxlength="255"></textarea>
                </label>

                <label>
                    Quantidade disponível
                    <input type="number" name="quantidade" placeholder="Número de unidades" min="1" required />
                </label>

                <div class="button-row">
                    <button type="submit" class="primary-btn">Registrar produto</button>
                </div>
            </form>

            <p class="small-note">Após registrar o produto, ele ficará visível na página inicial para usuários próximos ao CEP informado.</p>
            <p class="small-note"><a href="../php/home.php">Ir para Home</a></p>
        </div>
    </div>


</body>
<script src="../js/site-brand.js"></script>
</html>
