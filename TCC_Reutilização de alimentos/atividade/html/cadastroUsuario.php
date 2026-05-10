<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
</head>
<body>
    <div class="auth-page">
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <span>❤️</span>
                    <h1>FomeOff</h1>
                </div>
                <h2>Conecte-se à solidariedade</h2>
                <p>Cadastre sua conta e ajude quem mais precisa com doações perto de você.</p>
            </div>

            <div class="brand-features">
                <div class="feature-card">
                    <span>🕛</span>
                    <div>
                        <strong>Locais próximos</strong>
                        <p>Encontre doações perto de você.</p>
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
                    <h3>Criar conta</h3>
                    <p>Preencha seus dados para participar da rede.</p>
                </div>

                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="../php/cadastrarUsuario.php" method="post">
                    <label>
                        Nome completo
                        <input type="text" name="nome" placeholder="Seu nome" required minlength="3" maxlength="30" />
                    </label>

                    <label>
                        Email
                        <input type="email" name="email" placeholder="seu@email.com" required />
                    </label>

                    <label>
                        Senha
                        <input type="password" name="senha" placeholder="••••••••" required minlength="3" maxlength="8" />
                    </label>

                    <button type="submit" class="primary-btn">Criar conta</button>
                </form>

                <p class="form-footer">
                    Já tem conta?
                    <a href="../index.php">Faça login</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>