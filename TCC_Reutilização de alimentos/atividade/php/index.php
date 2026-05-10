<?php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Entrar | FomeOff</title>
    <link rel="stylesheet" href="./css/index.css" />
</head>
<body>
    <div class="auth-page">
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <span>🛍️</span>
                    <h1>FomeOff</h1>
                </div>
                <h2>Conectando solidariedade em tempo real</h2>
                <p>Encontre empresas e ONGs que doam alimentos perto de você.</p>
            </div>

            <div class="brand-features">
                <div class="feature-card">
                    <span>🕛</span>
                    <div>
                        <strong>Locais próximos</strong>
                        <p>Doações perto de você.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span>⚡</span>
                    <div>
                        <strong>Tempo real</strong>
                        <p>Atualizações instantâneas.</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="form-panel">
            <div class="form-card">
                <div class="form-header">
                    <h3>Bem-vindo de volta!</h3>
                    <p>Entre para encontrar ajuda próxima a você.</p>
                </div>

                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="./php/login.php" method="post">
                    <label>
                        Email
                        <input type="email" name="email" placeholder="seu@email.com" required />
                    </label>

                    <label>
                        Senha
                        <input type="password" name="senha" placeholder="••••••••" required minlength="3" maxlength="8" />
                    </label>

                    <button type="submit" class="primary-btn">Entrar</button>
                </form>

                <p class="form-footer">
                    Não tem cadastro?
                    <a href="./html/cadastroUsuario.php">Cadastre-se</a>
                </p>
                <p class="form-footer">
                    Sou empresa? <a href="./html/cadastroProduto.php">Cadastrar produto disponível</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>