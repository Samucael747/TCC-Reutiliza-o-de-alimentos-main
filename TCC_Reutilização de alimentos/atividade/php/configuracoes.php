<?php
session_start();
if (!isset($_SESSION['nome'], $_SESSION['email'], $_SESSION['role'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require 'conexao.php';

if (!$pdo) {
    die('Erro de conexão com o banco de dados. Tente novamente mais tarde.');
}

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
$role    = $_SESSION['role'];
$email   = $_SESSION['email'];

if ($role === 'empresa') {
    $stmt = $pdo->prepare('SELECT nome, email, senha, cnpj, cep FROM empresas WHERE email = :email LIMIT 1');
} else {
    $stmt = $pdo->prepare('SELECT nome, email, senha FROM usuarios WHERE email = :email LIMIT 1');
}
$stmt->execute([':email' => $email]);
$conta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conta) {
    header('Location: ../entrar.php?error=Conta+nao+encontrada');
    exit;
}

$fotoPerfil      = null;
$fotoPlaceholder = '../images/user-placeholder.png';

$paginaAtiva = 'configuracoes';
$pageTitle   = 'Configurações | FomeOff';
$extra_head  = <<<'HTML'
    <style>
        body {
            background: linear-gradient(180deg, #FFF3E0 0%, #FFE4B5 100%);
            min-height: 100vh;
        }

        .content-wrapper {
            max-width: 800px;
            margin: 40px auto;
            padding: 24px;
        }

        .settings-container { display: grid; gap: 24px; }

        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            padding: 28px;
            border-top: 4px solid #FF8C00;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 60px rgba(0,0,0,0.12);
        }

        .card h2 {
            margin-top: 0;
            color: #E8411C;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.4rem;
        }

        .card p { margin: 8px 0 20px; color: #666; font-size: 0.95rem; }

        .profile-section {
            text-align: center;
            margin-bottom: 28px;
            padding-bottom: 28px;
            border-bottom: 2px solid #F0F0F0;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 16px;
            object-fit: cover;
            border: 4px solid #FF8C00;
            box-shadow: 0 4px 12px rgba(255,140,0,0.2);
            display: block;
        }

        .upload-wrapper { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }

        .file-input-label {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .file-input-label:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,140,0,0.3); }

        #foto-input { display: none; }
        .upload-hint { font-size: 0.85rem; color: #999; }

        .settings-grid { display: grid; gap: 18px; }

        .settings-grid label {
            display: grid;
            gap: 8px;
            color: #333;
            font-weight: 600;
        }

        .settings-grid input,
        .settings-grid select {
            padding: 12px 14px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .settings-grid input:focus,
        .settings-grid select:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 3px rgba(255,140,0,0.1);
        }

        .accessibility-card-section {
            background: linear-gradient(135deg, rgba(255,140,0,0.05), rgba(253,184,19,0.05));
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            border-left: 4px solid #FF8C00;
        }

        .accessibility-card-section h3 { margin: 0 0 12px; color: #E8411C; display: flex; align-items: center; gap: 8px; }
        .accessibility-card-section p  { margin: 0 0 16px; color: #666; font-size: 0.9rem; }

        .accessibility-btn-open {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #E8411C, #FF6C3C);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .accessibility-btn-open:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(232,65,28,0.3); }

        .actions-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid #F0F0F0;
        }

        .primary-btn {
            padding: 12px 28px;
            background: linear-gradient(135deg, #FF8C00, #FDB813);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .primary-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,140,0,0.3); }

        .actions-row a {
            color: #E8411C;
            font-weight: 600;
            text-decoration: none;
            padding: 12px 28px;
            border: 2px solid #E8411C;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .actions-row a:hover { background: #E8411C; color: white; }

        .message {
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .message.success { background: #E8F5E9; color: #256029; border-left: 4px solid #4CAF50; }
        .message.error   { background: #FFEBEE; color: #C62828; border-left: 4px solid #F44336; }

        .loading { display: none; text-align: center; padding: 12px; color: #FF8C00; font-weight: 600; }

        @media (max-width: 768px) {
            .content-wrapper { margin: 20px auto; padding: 16px; }
            .card { padding: 20px; }
            .actions-row { flex-direction: column; }
            .actions-row a, .primary-btn { width: 100%; text-align: center; }
        }
    </style>
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/head.php'; ?>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="content-wrapper">
        <div class="settings-container">

            <!-- Perfil -->
            <div class="card">
                <h2><i class="bi bi-person-circle"></i> Perfil</h2>
                <p>Personalize sua foto e informações básicas</p>

                <?php if ($success): ?>
                    <div class="message success">✓ <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="message error">✕ <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <div class="profile-section">
                    <img src="<?php echo $fotoPerfil ? htmlspecialchars($fotoPerfil, ENT_QUOTES, 'UTF-8') : $fotoPlaceholder; ?>"
                         alt="Foto de perfil" class="profile-avatar" id="preview-foto" />
                    <div class="upload-wrapper">
                        <input type="file" id="foto-input" accept="image/*" onchange="uploadFoto(event)" />
                        <label for="foto-input" class="file-input-label"><i class="bi bi-camera"></i> Alterar Foto</label>
                        <span class="upload-hint">JPG, PNG, GIF ou WebP • Máx 5MB</span>
                        <div class="loading" id="upload-loading">Enviando...</div>
                    </div>
                </div>

                <form action="salvarConfiguracoes.php" method="post" class="settings-grid">
                    <label>
                        <span class="field-label"><?php echo $role === 'empresa' ? '<i class="bi bi-building"></i> Nome da empresa / ONG' : '<i class="bi bi-person"></i> Nome completo'; ?></span>
                        <input type="text" name="nome"
                               value="<?php echo htmlspecialchars($conta['nome'], ENT_QUOTES, 'UTF-8'); ?>"
                               required maxlength="100" />
                    </label>

                    <?php if ($role === 'empresa'): ?>
                        <label>
                            <span class="field-label"><i class="bi bi-card-text"></i> CNPJ</span>
                            <input type="text" name="cnpj"
                                   value="<?php echo htmlspecialchars($conta['cnpj'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                   maxlength="20" />
                        </label>
                        <label>
                            <span class="field-label"><i class="bi bi-geo-alt"></i> CEP</span>
                            <input type="text" name="cep"
                                   value="<?php echo htmlspecialchars($conta['cep'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                   maxlength="10" />
                        </label>
                    <?php endif; ?>

                    <label>
                        <span class="field-label"><i class="bi bi-envelope"></i> Email de login</span>
                        <input type="email" name="email"
                               value="<?php echo htmlspecialchars($conta['email'], ENT_QUOTES, 'UTF-8'); ?>"
                               required maxlength="100" />
                    </label>

                    <label>
                        <span class="field-label"><i class="bi bi-lock"></i> Nova senha</span>
                        <input type="password" name="senha"
                               placeholder="Deixe em branco para manter a senha atual"
                               minlength="3" maxlength="50" />
                    </label>

                    <div class="actions-row">
                        <button type="submit" class="primary-btn"><i class="bi bi-floppy"></i> Salvar Alterações</button>
                        <a href="home.php"><i class="bi bi-arrow-left"></i> Voltar</a>
                    </div>
                </form>
            </div>

            <!-- Acessibilidade -->
            <div class="card">
                <h2><i class="bi bi-universal-access"></i> Acessibilidade</h2>
                <p>Ajuste o tamanho da fonte, contraste e outras configurações de acessibilidade.</p>

                <div class="accessibility-card-section">
                    <h3>⚙️ Painel de Acessibilidade</h3>
                    <p>Use o painel para personalizar sua experiência de navegação.</p>
                    <button class="accessibility-btn-open"
                            onclick="document.getElementById('accessibility-panel')?.classList.toggle('active')">
                        <i class="bi bi-sliders"></i> Abrir Painel de Acessibilidade
                    </button>
                </div>
            </div>

        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>

    <script src="../js/accessibility.js"></script>
    <script>
        function uploadFoto(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                alert('Arquivo muito grande. Máximo 5MB.');
                return;
            }

            const preview = document.getElementById('preview-foto');
            const reader = new FileReader();
            reader.onload = function(e) { preview.src = e.target.result; };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>

