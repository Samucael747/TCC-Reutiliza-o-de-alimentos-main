<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Empresa | SolidárioConnect</title>
    <link rel="stylesheet" href="../css/index.css" />
</head>
<body>
    <div class="auth-page">
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <span>❤️</span>
                    <h1>SolidárioConnect</h1>
                </div>
                <h2>Cadastre sua empresa</h2>
                <p>Junte-se à rede e comece a distribuir alimentos para quem mais precisa.</p>
            </div>

            <div class="brand-features">
                <div class="feature-card">
                    <span>📍</span>
                    <div>
                        <strong>Alcance local</strong>
                        <p>Conecte-se a pessoas próximas.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span>⚡</span>
                    <div>
                        <strong>Impacto real</strong>
                        <p>Suas doações chegam rápido.</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="form-panel">
            <div class="form-card">
                <div class="form-header">
                    <h3>Criar conta de empresa</h3>
                    <p>Preencha os dados da sua empresa para participar da rede.</p>
                </div>

                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="../controllers/cadastrarEmpresa.php" method="post">
                    <label>
                        Nome da empresa
                        <input type="text" name="empresa" placeholder="Nome fantasia" required minlength="3" maxlength="100" />
                    </label>

                    <label>
                        CNPJ
                        <input type="text" name="cnpj" placeholder="00.000.000/0000-00" required minlength="14" maxlength="18" />
                    </label>

                    <label>
                        CEP
                        <input type="text" name="cep" placeholder="00000-000" required minlength="8" maxlength="9" />
                    </label>

                    <label>
                        Responsável
                        <input type="text" name="nome" placeholder="Nome do responsável" required minlength="3" maxlength="100" />
                    </label>

                    <label>
                        Email
                        <input type="email" name="email" placeholder="empresa@email.com" required />
                    </label>

                    <label>
                        Senha
                        <input type="password" name="senha" placeholder="••••••••" required minlength="3" maxlength="8" />
                    </label>

                    <button type="submit" class="primary-btn">Cadastrar empresa</button>
                </form>

                <p class="form-footer">
                    Já tem cadastro?
                    <a href="../index.php">Faça login</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
