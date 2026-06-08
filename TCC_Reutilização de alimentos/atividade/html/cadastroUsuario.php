<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Criar Conta | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/acessibilidade.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <style>
        body, input, select, button, textarea, label {
            font-family: 'Inter', system-ui, sans-serif;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #fff;
        }

        .brand-logo img {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
        }

        .message {
            padding: 14px 16px;
            border-radius: 14px;
            margin: 16px 0 0;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .message.error {
            background: #fff1f2;
            color: #be123c;
            border-left: 4px solid #f43f5e;
        }

        i.bi { margin-right: 5px; }
    </style>
</head>
<body>
    <div class="auth-page">

        <!-- Painel esquerdo — marca -->
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <img src="../Imagens/Logo.png" alt="Logo FomeOff" />
                    FomeOff
                </div>
                <h2>Conecte-se à FomeOff</h2>
                <p>Cadastre sua conta e ajude quem mais precisa com doações perto de você.</p>
            </div>

            <div class="brand-features">
                <div class="feature-card">
                    <span><i class="bi bi-geo-alt-fill" style="font-size:1.3rem;"></i></span>
                    <div>
                        <strong>Locais próximos</strong>
                        <p>Encontre doações perto de você.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span><i class="bi bi-lightning-charge-fill" style="font-size:1.3rem;"></i></span>
                    <div>
                        <strong>Tempo real</strong>
                        <p>Atualizações instantâneas.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span><i class="bi bi-heart-fill" style="font-size:1.3rem;"></i></span>
                    <div>
                        <strong>Solidariedade</strong>
                        <p>Conectando quem doa a quem precisa.</p>
                    </div>
                </div>
            </div>

            <div class="brand-action">
                <a class="brand-link" href="../php/leis_doacoes.php">
                    <i class="bi bi-book"></i> Conheça as leis sobre doações
                </a>
            </div>
        </aside>

        <!-- Painel direito — formulário -->
        <main class="form-panel">
            <div class="form-card">
                <div class="form-header">
                    <h3>Criar conta</h3>
                    <p>Preencha seus dados para participar da rede.</p>
                </div>

                <?php if ($error): ?>
                    <div class="message error">
                        <i class="bi bi-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <form action="../php/cadastrarUsuario.php" method="post">
                    <label>
                        <span class="field-label"><i class="bi bi-person"></i> Nome completo</span>
                        <input type="text" name="nome" placeholder="Seu nome completo"
                               required minlength="3" maxlength="100" />
                    </label>

                    <label>
                        <span class="field-label"><i class="bi bi-envelope"></i> Email</span>
                        <input type="email" name="email" placeholder="seu@email.com" required />
                    </label>

                    <label>
                        <span class="field-label"><i class="bi bi-lock"></i> Senha</span>
                        <input type="password" name="senha" placeholder="••••••••"
                               required minlength="3" maxlength="50" />
                    </label>
                    <label>
                        <span class="field-label"><i class="bi bi-lock"></i> Confirmar senha</span>
                        <input type="password" name="confirmar_senha" placeholder="••••••   ••"
                               required minlength="3" maxlength="50" />

                    <button type="submit" class="primary-btn">
                        <i class="bi bi-person-plus"></i> Criar conta
                    </button>
                </form>

                <p class="form-footer">
                    Já tem conta? <a href="../entrar.php">Faça login</a>
                </p>
                <p class="form-footer">
                    Sou empresa? <a href="cadastroEmpresas.html">Cadastre sua empresa / ONG</a>
                </p>
            </div>
        </main>

    </div>
    <link rel="stylesheet" href="../css/accessibility-panel.css" />
    <script src="../js/accessibility.js"></script>
</body>
</html>

