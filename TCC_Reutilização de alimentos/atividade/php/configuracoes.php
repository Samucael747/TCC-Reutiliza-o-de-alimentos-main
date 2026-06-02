<?php
session_start();
if (!isset($_SESSION['nome'], $_SESSION['email'], $_SESSION['role'])) {
    header('Location: ../entrar.php?error=Voce+precisa+logar+primeiro');
    exit;
}

require __DIR__ . '/includes/conexao.php';

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
    <link rel="stylesheet" href="../css/configuracoes.css" />
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

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

                <form action="actions/salvarConfiguracoes.php" method="post" class="settings-grid">
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

    <?php include __DIR__ . '/includes/footer.php'; ?>

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



