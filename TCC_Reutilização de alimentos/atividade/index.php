<?php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
$pageTitle = 'Entrar | FomeOff';
include 'php/head.php';
?>
<body>
    <?php include 'php/header.php'; ?>
    <div class="auth-page">
        <aside class="brand-panel">
            <div>
                <div class="brand-logo">
                    <img src="./Imagens/Logo.png" alt="Logo FomeOff" class="site-logo" />
                </div>
                <h2>Conectando pessoas em tempo real</h2>
                <p>Encontre empresas e ONGs que doam alimentos perto de você.</p>
            </div>

                <figure class="brand-image">
                </figure>

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
                    <p>Esta plataforma conecta empresas e ONGs que têm alimentos disponíveis com quem precisa. Ao doar, você evita desperdício, fortalece cadeias locais e transforma vidas. A contribuição de cada organização significa menos pessoas em filas, menos comida desperdiçada e mais dignidade para famílias vulneráveis.</p>
                </div>
            </section>
        </aside>

        <main class="form-panel">
            <div class="form-card">
                <div class="form-header">
                    <h3>Bem-vindo de volta!</h3>
                    <p>Encontre o centro de doação mais próximo de você.</p>
                    <button type="button" class="chat-open-btn" onclick="window.chatbotManager?.open()">Precisa de ajuda? Abra o chat</button>
                </div>

                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="message success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="./php/login.php" method="post">
                    <label>
                        Tipo de conta
                        <select name="tipo" required>
                            <option value="usuario">Usuário</option>
                            <option value="empresa">Empresa / ONG</option>
                        </select>
                    </label>

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
                    Sou empresa? <a href="./html/cadastroEmpresas.html">Cadastre sua empresa / ONG</a>
                </p>
                <p class="form-footer">
                    <a href="./php/leis_doacoes.php">📋 Conheça as leis sobre doações de alimentos</a>
                </p>
            </div>
        </main>
    </div>
    <script src="./js/chatbot.js"></script>
    <script src="./js/site-brand.js"></script>
</body>
</html>