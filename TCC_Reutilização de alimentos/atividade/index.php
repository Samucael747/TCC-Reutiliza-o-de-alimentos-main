<?php
$error   = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FomeOff — Entrar</title>
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/acessibilidade.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <style>
        /* ── Login page overrides ── */
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

        .form-card {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .form-header { margin-bottom: 0; }

        form { margin-top: 24px; gap: 18px; }

        select {
            width: 100%;
            padding: 16px 18px;
            border: 1px solid #E0B299;
            border-radius: 18px;
            background: #FFF8F0;
            font: inherit;
            color: #111827;
            transition: border-color 0.25s, box-shadow 0.25s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23999' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
        }

        select:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 4px rgba(255,140,0,0.15);
        }

        .message {
            padding: 14px 16px;
            border-radius: 14px;
            margin: 16px 0 0;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .message.error   { background: #fff1f2; color: #be123c; border-left: 4px solid #f43f5e; }
        .message.success { background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; }

        .form-footer { margin-top: 14px; }
        .form-footer a { color: #FF8C00; }

        .chat-open-btn {
            margin-top: 12px;
            padding: 9px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            background: transparent;
            color: #6b7280;
            font: inherit;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chat-open-btn:hover { border-color: #FF8C00; color: #FF8C00; }

        /* Stats */
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            margin-top: 20px;
        }

        .stat-card strong { font-size: 1.6rem; }

        /* Maps */
        .maps-grid { margin-top: 20px; }

        /* Idea card */
        .idea-card { margin-top: 20px; }

        @media (max-width: 960px) {
            .brand-panel { padding: 32px 24px; }
        }
    </style>
</head>
<body>
    <div class="auth-page">

        <!-- Painel esquerdo — marca -->
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <img src="./Imagens/Logo.png" alt="Logo FomeOff" />
                    FomeOff
                </div>
                <h2>Conectando pessoas em tempo real</h2>
                <p>Encontre empresas e ONGs que doam alimentos perto de você.</p>
            </div>

            <div class="brand-features">
                <div class="feature-card">
                    <span><i class="bi bi-geo-alt-fill"></i></span>
                    <div>
                        <strong>Locais próximos</strong>
                        <p>Doações perto de você.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span><i class="bi bi-lightning-charge-fill"></i></span>
                    <div>
                        <strong>Tempo real</strong>
                        <p>Atualizações instantâneas.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <span><i class="bi bi-heart-fill"></i></span>
                    <div>
                        <strong>Solidariedade</strong>
                        <p>Conectando quem doa a quem precisa.</p>
                    </div>
                </div>
            </div>

            <div class="brand-action">
                <a class="brand-link" href="./sensibilizacao.html">Conheça nossa causa</a>
            </div>

            <section class="awareness">
                <h3>Doar salva vidas</h3>
                <p>Hoje, mais de <strong>828 milhões</strong> de pessoas no mundo passam fome. No Brasil, cerca de <strong>33 milhões</strong> vivem com insegurança alimentar. Cada empresa ou ONG que doa transforma excedente em esperança.</p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <strong>828M</strong>
                        <span>Pessoas sem comida suficiente no mundo</span>
                    </div>
                    <div class="stat-card">
                        <strong>33M</strong>
                        <span>Brasileiros em insegurança alimentar</span>
                    </div>
                    <div class="stat-card">
                        <strong>1/3</strong>
                        <span>Dos alimentos produzidos são desperdiçados</span>
                    </div>
                </div>

                <div class="maps-grid">
                    <article class="map-card">
                        <strong>Mapa da fome no Brasil</strong>
                        <div class="map-graphic brasil-map">
                            <span class="map-pin top-left">Norte</span>
                            <span class="map-pin top-right">Nordeste</span>
                            <span class="map-pin bottom-left">Centro-Oeste</span>
                            <span class="map-pin bottom-right">Sudeste</span>
                            <span class="map-pin bottom-center">Sul</span>
                        </div>
                        <p>Regiões com maior incidência de insegurança alimentar no país.</p>
                    </article>
                    <article class="map-card">
                        <strong>Mapa mundial</strong>
                        <div class="map-graphic world-map">
                            <span class="map-tag">África</span>
                            <span class="map-tag">América Latina</span>
                            <span class="map-tag">Ásia</span>
                        </div>
                        <p>Áreas com maiores desafios de acesso a alimentos.</p>
                    </article>
                </div>

                <div class="idea-card">
                    <h4>Como nossa ideia faz diferença</h4>
                    <p>Esta plataforma conecta empresas e ONGs que têm alimentos disponíveis com quem precisa. Ao doar, você evita desperdício, fortalece cadeias locais e transforma vidas.</p>
                </div>
            </section>
        </aside>

        <!-- Painel direito — formulário -->
        <main class="form-panel">
            <div class="form-card">
                <div class="form-header">
                    <h3>Bem-vindo de volta!</h3>
                    <p>Encontre o centro de doação mais próximo de você.</p>
                    <button type="button" class="chat-open-btn"
                            onclick="window.chatbotManager?.open()">
                        <i class="bi bi-chat-dots"></i> Precisa de ajuda? Abra o chat
                    </button>
                </div>

                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="./php/login.php" method="post">
                    <label>
                        <i class="bi bi-person-badge"></i> Tipo de conta
                        <select name="tipo" required>
                            <option value="usuario">Usuário</option>
                            <option value="empresa">Empresa / ONG</option>
                        </select>
                    </label>
                    <label>
                        <i class="bi bi-envelope"></i> Email
                        <input type="email" name="email" placeholder="seu@email.com" required />
                    </label>
                    <label>
                        <i class="bi bi-lock"></i> Senha
                        <input type="password" name="senha" placeholder="••••••••" required minlength="3" maxlength="50" />
                    </label>
                    <button type="submit" class="primary-btn">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </form>

                <p class="form-footer">
                    Não tem cadastro?
                    <a href="./html/cadastroUsuario.php">Cadastre-se</a>
                </p>
                <p class="form-footer">
                    Sou empresa?
                    <a href="./html/cadastroEmpresas.html">Cadastre sua empresa / ONG</a>
                </p>
                <p class="form-footer">
                    <a href="./php/leis_doacoes.php"><i class="bi bi-book"></i> Conheça as leis sobre doações</a>
                </p>
            </div>
        </main>
    </div>

    <script src="./js/chatbot.js"></script>
    <link rel="stylesheet" href="./css/accessibility-panel.css" />
    <script src="./js/accessibility.js"></script>
</body>
</html>
