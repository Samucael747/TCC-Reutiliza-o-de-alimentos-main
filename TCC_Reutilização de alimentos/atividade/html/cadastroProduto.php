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
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(180deg, #FFE4B5 0%, #FFF3E0 100%);
        }
        .content-wrapper { max-width: 760px; margin: 32px auto; padding: 20px; }
        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(232,65,28,0.08);
            padding: 32px;
            border-top: 4px solid #FF8C00;
        }
        .card h2 { margin-top: 0; color: #E8411C; display:flex; align-items:center; gap:10px; font-size: 1.4rem; }
        .card > p { color: #6b7280; margin-bottom: 24px; font-size: 0.95rem; }
        .form-grid { display: grid; gap: 20px; }
        .form-grid label { display: grid; gap: 8px; font-family: 'Inter', Arial, sans-serif; }
        .form-grid input,
        .form-grid textarea,
        .form-grid select {
            padding: 13px 16px;
            border: 1.5px solid #E0B299;
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: 'Inter', Arial, sans-serif;
            background: #FFF8F0;
            color: #111827;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-grid input:focus,
        .form-grid textarea:focus,
        .form-grid select:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 3px rgba(255,140,0,0.12);
        }
        .form-grid input[type="file"] {
            padding: 10px 14px;
            background: #fff8f0;
            cursor: pointer;
        }
        .button-row { display: flex; gap: 12px; margin-top: 8px; flex-wrap: wrap; }
        .primary-btn {
            padding: 13px 28px;
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: 'Inter', Arial, sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .primary-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,140,0,0.3); }
        .btn-voltar {
            padding: 13px 24px;
            border: 2px solid #E8411C;
            background: transparent;
            color: #E8411C;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .btn-voltar:hover { background: #E8411C; color: white; }
        .small-note { font-size: 0.88rem; color: #9ca3af; margin-top: 16px; }
        .message { border-radius: 12px; padding: 14px 16px; margin-bottom: 18px; font-weight: 600; }
        .message.success { background: #ecfdf5; color: #065f46; border-left: 4px solid #22c55e; }
        .message.error   { background: #fff1f2; color: #be123c; border-left: 4px solid #f43f5e; }
        #preview-img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 12px;
            object-fit: cover;
            display: none;
            margin-top: 10px;
            border: 2px solid #ffe5cd;
        }
    </style>
HTML;
include '../php/head.php';
?>
<body>
    <?php include '../php/navbar.php'; ?>

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

            <form action="../php/salvarProduto.php" method="post" enctype="multipart/form-data" class="form-grid">

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

    <?php include '../php/footer.php'; ?>

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

