<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'empresa') {
    header('Location: ../entrar.php?error=Voce+precisa+logar+como+empresa');
    exit;
}
$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
$paginaAtiva = '';
$pageTitle   = 'Cadastrar Produto | FomeOff';
$extra_head  = <<<'HTML'
    <link rel="stylesheet" href="../css/cadastro-produto.css" />
HTML;
include '../php/includes/head.php';
?>
<body>
    <?php include '../php/includes/navbar.php'; ?>

    <div class="content-wrapper">
        <div class="card">
            <h2><i class="bi bi-plus-circle"></i> Cadastrar Produto para Doação</h2>
            <p>Informe os dados do produto disponível. Ele aparecerá no mapa para usuários próximos ao CEP informado.</p>

            <?php if ($success): ?>
                <div class="message success"><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><i class="bi bi-exclamation-circle"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form action="../php/actions/salvarProduto.php" method="post" enctype="multipart/form-data" class="form-grid">

                <label>
                    <span class="field-label"><i class="bi bi-building"></i> Nome da empresa</span>
                    <input type="text" name="empresa" placeholder="Nome da empresa" required maxlength="100"
                           value="<?php echo htmlspecialchars($_SESSION['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-card-text"></i> CNPJ</span>
                    <input type="text" name="cnpj" placeholder="00.000.000/0000-00" maxlength="20" />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-geo-alt"></i> CEP</span>
                    <input type="text" name="cep" placeholder="12345-678" required maxlength="10" />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-gift"></i> Nome do produto</span>
                    <input type="text" name="nome_produto" placeholder="Ex: Pães, frutas, marmitas" required maxlength="100" />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-calendar-event"></i> Validade</span>
                    <input type="date" name="validade" required />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-stack"></i> Quantidade disponível</span>
                    <input type="number" name="quantidade" placeholder="Número de unidades" min="1" required />
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-text-paragraph"></i> Descrição</span>
                    <textarea name="descricao" placeholder="Descreva o alimento e outras informações relevantes" required rows="4" maxlength="255"></textarea>
                </label>

                <label>
                    <span class="field-label"><i class="bi bi-image"></i> Foto do produto</span>
                    <input type="file" name="imagem" accept="image/png,image/jpeg,image/webp"
                           onchange="previewImagem(this)" />
                    <img id="preview-img" alt="Pré-visualização" />
                </label>

                <div class="button-row">
                    <button type="submit" class="primary-btn">
                        <i class="bi bi-check-circle"></i> Registrar produto
                    </button>
                    <a href="../php/home.php" class="btn-voltar">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </form>

            <p class="small-note">
                <i class="bi bi-info-circle"></i>
                Após registrar, o produto ficará visível no mapa para usuários próximos ao CEP informado.
            </p>
        </div>
    </div>

    <?php include '../php/includes/footer.php'; ?>

    <link rel="stylesheet" href="../css/accessibility-panel.css" />
    <script src="../js/accessibility.js"></script>
    <script>
        function previewImagem(input) {
            const img = document.getElementById('preview-img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>


